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
	];

	// Always applied before every request
	public $globals = [
		'before' => [ 
			'admincontrol' => [
				'except' => [
					'login', 'signup', 'logout', 'home/*', '/', 'connect/*', 'api', 'api/*', 'ajax/*', 'user/*', 'cli/*', 'error', 
					'error/*', 'install/*', 'curl', 'curl/*', 'home', 'home/*', 'requests', 'requests/*', 'resource', 'resource/*', 'resources', 
					'resources/*']
			], 
			'accesscontrol' => [
				'except' => [
					'login', 'signup', 'logout', 'home/*', '/', 'connect/*', 'api', 'api/*', 'ajax/*', 'cli/*', 'error', 'error/*', 
					'user/m', 'install/*', 'curl', 'curl/*', 'home', 'home/*', 'requests', 'requests/*', 'resource', 'resource/*', 'resources', 
					'resources/*']
			],  
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
		// 'admincontrosl' => ['before' => ['admin', 'admin/*']],
	];
}
