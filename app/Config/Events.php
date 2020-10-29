<?php namespace Config;

use CodeIgniter\Events\Events;
use CodeIgniter\Exceptions\FrameworkException;
use \App\Libraries\Account_Data;

/*
 * --------------------------------------------------------------------
 * Application Events
 * --------------------------------------------------------------------
 * Events allow you to tap into the execution of the program without
 * modifying or extending core files. This file provides a central
 * location to define your events, though they can always be added
 * at run-time, also, if needed.
 *
 * You create code that can execute by subscribing to events with
 * the 'on()' method. This accepts any form of callable, including
 * Closures, that will be executed when the event is triggered.
 *
 * Example:
 *      Events::on('create', [$myInstance, 'myMethod']);
 */

Events::on('pre_system', function () {
	if (ENVIRONMENT !== 'testing')
	{
		if (ini_get('zlib.output_compression'))
		{
			throw FrameworkException::forEnabledZlibOutputCompression();
		}

		while (ob_get_level() > 0)
		{
			ob_end_flush();
		}

		ob_start(function ($buffer) {
			return $buffer;
		});
	}

	/*
	 * --------------------------------------------------------------------
	 * Debug Toolbar Listeners.
	 * --------------------------------------------------------------------
	 * If you delete, they will no longer be collected.
	 */
	if (ENVIRONMENT !== 'production')
	{
		Events::on('DBQuery', 'CodeIgniter\Debug\Toolbar\Collectors\Database::collect');
		Services::toolbar()->respond();
	}
});

Events::on('logout', function($to)
{
	$ad = new Account_Data;
	$ad->logout();
	return _redirect(base_url($to?$to:'home'));
});

Events::on('redirect', function($to) 
{
 	return _redirect(base_url($to)); 
});

Events::on('login_redirect', function($uid, $to = null)
{
	$ad = new Account_Data; 
	$ad->user_login($uid);
	if ($ad->logged_in())
	{ 
        $request  = \Config\Services::request();  
    	$session  = \Config\Services::session();
        $users_m  = model('App\Models\UsersModel', false);

        if ($session->has('username') OR get_cookie('username')) 
        {
            $_user = ($session->get('username') ?? get_cookie('username'));
            $user  = $users_m->user_by_username($_user); 
            if (!empty($user)) 
            { 
                if (!empty($to)) 
                {
                    return _redirect(base_url($to)); 
                }
                return _redirect(base_url('dashboard'));   
            } 
        }  

        return _redirect(base_url('login'));  
	}

	return _redirect(base_url('home'));
});