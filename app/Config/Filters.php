<?php namespace Config;

use CodeIgniter\Config\BaseConfig;

class Filters extends BaseConfig
{
	// Makes reading things below nicer,
	// and simpler to change out script that's used.
	public $aliases = [
		'csrf'     => \CodeIgniter\Filters\CSRF::class,
		'toolbar'  => \CodeIgniter\Filters\DebugToolbar::class, 
		'accesscontrol' => \App\Filters\AccessFilter::class,
		'admincontrol'  => \App\Filters\AdminFilter::class, 
		'provide_info'  => \App\Filters\ProvideinfoFilter::class
	];

	// Always applied before every request
	public $globals = [
		'before' => [  
			//'honeypot'
			// 'csrf',
		],
		'after'  => [
			'toolbar',
			//'honeypot'
		],
	];

	// Works on all of a particular HTTP method
	// (GET, POST, etc) as BEFORE filters only
	//     like: 'post' => ['CSRF', 'throttle'],
	public $methods = [];

	// List filter aliases and any before/after uri patterns
	// that they should run on, like:
	//    'isLoggedIn' => ['before' => ['account/*', 'profiles/*']],
	public $filters = [ 
			'admincontrol' => ['before' => [
				'admin', 'admin/*', 'dashboard', 'user/posts'
			]],
			'provide_info' => ['after' => [
				'user', 'user/products', 'user/hubs', 'user/hubs/*', 'user/payments', 'user/payments/*', 'user/dashboard'
			]],
			'accesscontrol' => ['before' =>  [
				'user', 'user/account', 'user/account/*', 'user/products', 'user/hubs', 'user/hubs/*', 'user/payments', 
				'user/payments/*', 'user/posts', 'user/posts/*', 'user/dashboard', 'mail', 'mail/*'
			]],
		// 'admincontrosl' => ['before' => ['admin', 'admin/*']],
	];
}
