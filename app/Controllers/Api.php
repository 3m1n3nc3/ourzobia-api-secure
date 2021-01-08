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
	    $domain  = $this->request->getPost("domain");
	    $product = $this->request->getPost("product");
	    $license = $this->request->getPost("license");

	    if ($check = $this->actives_m->check($domain, $product, $license))
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
		$response       = 1;

	    // Check if it has Already been activated
	    $domain  = $this->request->getPost("domain");
	    $product = $this->request->getPost("product");
	    $license = $this->request->getPost("license");
	    
	    $check_now  = $this->actives_m->check($domain, $product, $license);
 		$get_domain = $this->products_m->getDomain($domain);

	    if ($check_now)
	    {  
			$data['success'] = true;
		    $data['status']  = 'info';
			$data['status_code'] = '202';
			$data['message'] = 'Product Already Activated!';
		}
		else
		{
	    	// Check the product
	    	$check = $this->products_m->check($post);

		    if ($check) 
		    {
			    if (time() > $check['expiry']) 
			    {
				    $data['message'] = 'Product Code Expired since ' . date("Y-m-d", $check['expiry']);
			    }
			    elseif ($post['license'] !== $check['license_type']) 
			    {
				    $data['message'] = "License not applicable for {$post['license']} package!";
			    }
			    else
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
		 		}
		    }
		    else
		    {
			    $data['message'] = 'Invalid Purchase Code!';  
				$response        = 0;
		    }

 			// Add analytic record
 			if (!empty($get_domain))
				$this->util->save_analysis('activations', $get_domain['id'], $get_domain["domain"], $response);
		}

		// Return the response
		return $this->response
			->setJSON($data)
            ->setHeader('Access-Control-Allow-Headers', 'Content-Type')
			->setHeader('Access-Control-Allow-Origin', '*')
			->setHeader('Access-Control-Allow-Methods', 'GET, HEAD, POST, OPTIONS');
	} 


    /**
     * Call this endpoint to check for updates 
     * @return CodeIgniter\View
     */
	public function check_updates()
	{  
		$data['success'] = false;
	    $data['status']  = 'error';
		$data['status_code'] = '400';
	    $data['message'] = 'An error occurred';

	    $updates_ = [];

	    $post    = $this->request->getPost();
		$product = $this->main_products_m->get_products(['title' => $post['product']]);

		if (!empty($product['id']))
		{
			$updates = $this->product_updates_m->get_updates(['pid' => $product['id'], 'type' => $post['type']]);
			if (!empty($updates)) 
			{
				foreach ($updates as $key => $update) 
				{
					if (file_exists(PUBLICPATH . $update['file'])) 
					{
				        $file_instance = new \CodeIgniter\Files\File($update['file']); 

						$updates_[] = [
							'message'  => $update['message'],
							'title'    => $update['title'],
							'filename' => $file_instance->getBasename(),
							'filesize' => $file_instance->getSizeByUnit('kb') . "kb",
							'link'     => site_url("download/" . base64_url($update['file']))
						]; 
					}
				}

				$single_update_exist = (count($updates) === 1 && file_exists(PUBLICPATH . $updates[0]['file']));

				$data['success'] = true;
			    $data['status']  = 'success';
		    	$data['status_code'] = '200';
			    $data['updates'] = $updates_;
			    $data['message'] = ($single_update_exist) ? $updates[0]['message'] : 'No Update Available!';
			    $data['title']   = ($single_update_exist) ? $updates[0]['title'] : null;
			    $data['href']    = ($single_update_exist) ? site_url("download/" . base64_url($updates[0]['file'])) : null;
			}
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
