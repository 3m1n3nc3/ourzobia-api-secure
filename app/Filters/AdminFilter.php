<?php namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AdminFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $account_data = new \App\Libraries\Account_Data;
        $session      = \Config\Services::session();   

        helper(['cookie', 'site']);

        // Check if logged_user() is an admin
        if ($account_data->logged_in()) 
        {
            if (!error_redirect(logged_user('admin'), '401', true)) return error_redirect(logged_user('admin'), '401');   
        } 

        // Remove access login token
        if ($session->has('password_token') && $request->uri->getSegment(1) !== 'mail') 
        {
            $session->remove('password_token'); 
        }

        if (! $session->has('access_folder') ) 
        { 
            $session->set('access_folder', 'admin');
        }
        
        return $account_data->is_logged_in();
    }

    //--------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
