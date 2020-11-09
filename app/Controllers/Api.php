<?php namespace App\Controllers;

class Api extends BaseController
{
    /**
     * Call this endpoint to validate or verify the 
     * status of a product installation 
     * @return CodeIgniter\HTTP
     */
	public function verify()
	{
		$data['success'] = false;
	    $data['status']  = 'error';
		$data['status_code'] = '400';
	    $data['message'] = 'An error occurred';  

	    // Check if it has been activated
	    if ($check = $this->actives_m->check($this->request->getPost("domain")??""))
	    { 
			$data['success'] = true;
		    $data['status']  = 'success';
		    $data['status_code'] = '200';
		    $data['message'] = 'Product is Active!'; 
		}
		else
		{
			$data['message'] = 'Product is Inactive!'; 
		}
 		
 		if ($check) 
 		{
	 		// Add analytic record
 			$this->util->save_analysis('validations', $check['pid'], $this->request->getPost("domain"));
 		}

		// Return the response
		return $this->response
			->setJSON($data) 
            ->setHeader('Access-Control-Allow-Headers', 'Content-Type')
			->setHeader('Access-Control-Allow-Origin', '*')
			->setHeader('Access-Control-Allow-Methods', 'OPTIONS, GET, POST');
	}


    /**
     * Call this endpoint to check, validate and
     * approve a new product activation request
     * @return CodeIgniter\HTTP
     */
	public function activate()
	{
		$data['success'] = false;
	    $data['status']  = 'error';
		$data['status_code'] = '400';
	    $data['message'] = 'An error occurred';  
		
	    $post = $this->request->getPost();
	    $post['status'] = 1;

	    // Check if it has Already been activated
	    if (empty($this->actives_m->check($this->request->getPost("domain")))) 
	    {
	    	// Check the product
		    if ($check = $this->products_m->check($post)) 
		    {
				$data['success'] = true;
			    $data['status']  = 'success';
		    	$data['status_code'] = '200';
			    $data['message'] = 'Product Successfully Activated!';
 				
 				$post['product_id'] = $check['id'];

 				// Add the product domain
 				$save['id'] 	= $post['product_id'];
 				$save['domain'] = $post['domain'];
 				$this->products_m->create($save);
 				// Activate the product
	 			$this->actives_m->create($post);
	 			// Add analytic record
				$this->util->save_analysis('activations', $check['id'], $post["domain"]);
		    }
		    else
		    {
			    $data['message'] = 'Invalid Purchase Code!';  
		    }
		}
		else
		{
			$data['success'] = true;
		    $data['status']  = 'info';
			$data['status_code'] = '202';
			$data['message'] = 'Product Already Activated!';
		}

		// Return the response
		return $this->response
			->setJSON($data)
            ->setHeader('Access-Control-Allow-Headers', 'Content-Type')
			->setHeader('Access-Control-Allow-Origin', '*')
			->setHeader('Access-Control-Allow-Methods', 'GET, HEAD, POST, OPTIONS');
	} 


    /**
     * Call this endpoint to generate the product 
     * activation form
     * @return CodeIgniter\View
     */
	public function form()
	{  
		$this->response->setHeader('Access-Control-Allow-Origin', '*');
		$this->response->setHeader('Access-Control-Allow-Methods', 'GET, POST');
		return view('form');
	} 
}
