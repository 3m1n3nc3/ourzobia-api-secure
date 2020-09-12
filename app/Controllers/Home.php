<?php namespace App\Controllers;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');

class Home extends BaseController
{
	public function index()
	{
		$this->response->setHeader('Access-Control-Allow-Origin', '*');
		$this->response->setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, DELETE');

		return view('welcome');
	} 

	public function form()
	{ 
		$this->response->setHeader('Access-Control-Allow-Origin', '*');
		$this->response->setHeader('Access-Control-Allow-Methods', 'GET, POST');

		return view('form');
	} 

	public function verify()
	{
		$data['success'] = false;
	    $data['status']  = 'error';
	    $data['message'] = 'An error occurred';  

	    if ($this->actives_m->check($this->request->getPost("domain")??""))
	    { 
			// $data['success'] = true;
		    $data['status']  = 'success';
		    $data['message'] = 'Product is Active!';
		}
		else
		{
			$data['message'] = 'Product is Inactive!';
		}

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

	    if (empty($this->actives_m->check($post["domain"]))) 
	    { 
		    if ($this->products_m->check($post)) 
		    {
				$data['success'] = true;
			    $data['status']  = 'success';
			    $data['message'] = 'Product Successfully Activated!';

	 			$this->actives_m->create($post);
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

		return $this->response
			->setJSON($data)
            ->setHeader('Access-Control-Allow-Headers', 'Content-Type')
			->setHeader('Access-Control-Allow-Origin', '*')
			->setHeader('Access-Control-Allow-Methods', 'GET, HEAD, POST, OPTIONS');
	} 
}
