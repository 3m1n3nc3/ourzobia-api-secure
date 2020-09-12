<?php namespace App\Controllers;

class Home extends BaseController
{
	public function index()
	{
		return view('welcome');
	}  

	public function activate()
	{	  
		$this->response->setHeader('Access-Control-Allow-Origin', '*');
		$this->response->setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, DELETE');
		  
 
	} 
}
