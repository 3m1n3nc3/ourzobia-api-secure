<?php namespace App\Controllers;  

class Home extends BaseController
{
	public function index()
	{
		$userdata  = $this->account_data->fetch(user_id());
		$view_data = array(
			'session' 	 => $this->session,
			'user' 	     => $userdata,
			'page_title' => 'Welcome',
			'page_name'  => 'homepage',  
			'set_folder' => 'frontend/', 
			'acc_data'   => $this->account_data,
			'util'       => $this->util,
			'creative'   => $this->creative
		);  
		return theme_loader($view_data, 'frontend/index'); 
	} 

	public function form()
	{ 
		// print_r($this->products_m->check(['email'=>'mygames.ng@gmail.com','code'=>'EBUVMMUZX','domains' => 'ourzobia.te']));

		$this->response->setHeader('Access-Control-Allow-Origin', '*');
		$this->response->setHeader('Access-Control-Allow-Methods', 'GET, POST');
		return view('form');
	} 

	public function verify()
	{
		$data['success'] = false;
	    $data['status']  = 'error';
	    $data['message'] = 'An error occurred';  

	    // Check if it has been activated
	    if ($check = $this->actives_m->check($this->request->getPost("domain")??""))
	    { 
			$data['success'] = true;
		    $data['status']  = 'success';
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

	public function activate()
	{
		$data['success'] = false;
	    $data['status']  = 'error';
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
			$data['message'] = 'Product Already Activated!';
		}

		// Return the response
		return $this->response
			->setJSON($data)
            ->setHeader('Access-Control-Allow-Headers', 'Content-Type')
			->setHeader('Access-Control-Allow-Origin', '*')
			->setHeader('Access-Control-Allow-Methods', 'GET, HEAD, POST, OPTIONS');
	} 
}
