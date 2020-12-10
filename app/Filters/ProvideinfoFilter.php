<?php namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class ProvideinfoFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Do something here
    }

    //--------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        $account_data = new \App\Libraries\Account_Data; 
        $session      = \Config\Services::session();   

        // Remove access login token
        if ($session->has('password_token') && $request->uri->getSegment(1) !== 'mail') 
        {
            $session->remove('password_token'); 
        }

        return $account_data->no_info_redirect();
    }
}
