<?php namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AccessFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
    	helper('cookie_helper');

        $account_data  = new \App\Libraries\Account_Data;
        $session       = \Config\Services::session();  
        // $request       = \Config\Services::request();
        $usersModel    = model('App\Models\UsersModel', false); 

        if ($request->uri->getSegment(1) == 'user') 
        {
            $session->set('access_folder', 'user'); 
        }

        if ($session->has('username') && ! $session->has('access_folder') ) 
        {
            $userdata      = $usersModel->user_by_username($session->get('username'));  
            $access_folder = ($userdata['admin'] > 0) ? 'admin' : 'user';
            $session->set('access_folder', $access_folder);
        }

        if (in_array($request->uri->getSegment(1), ['playground']) || in_array($request->uri->getSegment(2), ['post'])) 
        {
            return true;
        }

        if ($request->uri->getSegment(1) !== 'm' && $request->uri->getSegment(2) !== 'm' && !$request->getGet('token')) 
        {
            return $account_data->is_logged_in();
        }
    }

    //--------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
