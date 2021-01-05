<?php namespace App\Controllers;
 
use CodeIgniter\CLI\CLI AS CLINT;
use CodeIgniter\Controller;

class Cli extends Controller 
{   
	protected $helpers = ['site','tp_plugins', 'locale', 'theme', 'filesystem', 'cookie'];
 
	public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
	{
		// Do Not Edit This Line
		parent::initController($request, $response, $logger);

		//--------------------------------------------------------------------
		// Preload any models, libraries, etc, here.
		//--------------------------------------------------------------------  

        // Init all models globally  
        $this->analytics_m = model('App\Models\AnalyticsModel', false); 
        $this->users_m     = model('App\Models\UsersModel', false);
	}

	public function index()
	{  	   
		$i = 0;

		if (my_config('cron_jobs', NULL, 0)) 
		{
			CLINT::write("CLI Interface reached...", 'red'); 
 
 			// Fetch IP info for analytics items without ip_info
			$ip_chunks = $this->analytics_m->where(['uip !='=>NULL, 'ip_info'=>NULL])
				->orLike(['ip_info'=>'"type":null,"continent_code":null,"continent_name:null'], '', 'both', true, true)
				->orLike(['ip_info'=>'"country_code":null,"country_name":null'], '', 'both', true, true)
				->chunk(100, function ($analytics)
			{ 
				if (!in_array($analytics['uip'], ['127.0.0.1', '127.0.0.0', '0.0.0.0'])) 
				{	
					$ip_user = $this->users_m->get_user(['uip'=>$analytics['uip']]);
					$user_id = (!empty($ip_user['uid'])) ? $ip_user['uid'] : null;
		        	$this->analytics_m->add(['id'=>$analytics['id'], 'uip'=>$analytics['uip'], 'uid'=>$user_id]); 
				}
			});  
		}
		else
		{
			CLINT::write("Crone Jobs have been disabled from the configuration settings.", 'red');
		}
	}  
}