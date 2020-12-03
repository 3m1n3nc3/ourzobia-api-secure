<?php namespace App\Libraries; 

use DateTime; 

class Account_Data { 

    function __construct() 
    {
        $this->session    = \Config\Services::session();    
        $this->creative   = new \App\Libraries\Creative_lib;  
        $this->usersModel = model('App\Models\UsersModel', false);
        $this->util       = new \App\Libraries\Util;

        helper(['site']);
    }

    public function email2username(String $email)
    {    
        $email = explode('@', $email);
        array_pop($email); 
        return (String) $email[0];
    }   

    /*
     * this checks to see if the admin is logged in
     * we can provide a link to redirect to, and for the login page, we have $default_redirect,
     * this way we can check if they are already logged in, but we won't get stuck in an infinite loop if it returns false.
     */
    public function user_id($default = null)
    {    
        if ($this->logged_in()) 
        {
            $_user = ($this->session->get('username') ?? get_cookie('username'));
            $user  = $this->usersModel->user_by_username($_user); 
            return $user['uid'];
        } 

        return $default;
    }  


    /**
     * Method to verify user account
     * Best used as a filter
     * @return mixed
     */
    public function no_info_verify()
    {
        $request  = \Config\Services::request();   

        helper('theme');
        // Check if the user is not verified
        if (!logged_user('verified') && my_config('send_activation', null, false))
        { 
            $now_time   = new DateTime(date('Y-m-d H:i:s', time()));
            $past_time  = new DateTime(date('Y-m-d H:i:s', logged_user('last_update')));
            $time_diff  = $now_time->diff($past_time);  

            $minute_diff = ($time_diff->days * 24 * 60) + ($time_diff->h * 60) + $time_diff->i;  
 
            // Check if the user has provided a token
            if ($request->getGet('token')) 
            {
                $activation_successully_done = false;

                $tokened = $this->usersModel->user_by_token($request->getGet('token'));
                if ($minute_diff >= my_config('token_lifespan', null, 5) || !$tokened) 
                {
                    $act['status']  = 'error';
                    $act['message'] = _lang('m_expired_token');
                }
                else
                {
                    // Activate the account
                    $activation_successully_done = true;
                    $act = welcomeEmail(logged_user('username'), 'welcome', false);
                }

                $this->session->setFlashdata('notice', alert_notice($act['message'], $act['status'], FALSE, FALSE, NULL, 'Notice'));

                if ($activation_successully_done === true)
                {
                    return redirect()->to(base_url('user/account'));
                }

                return false;
            }
        }
    }


    /**
     * Method to check if user account is missing any required information
     * Best used as a filter
     * @return mixed
     */
    public function no_info_redirect()
    {
        $request  = \Config\Services::request();  

        helper('cookie');
        if ($this->logged_in()) 
        {
            // Check if the user is not verified
            if (!logged_user('verified') && my_config('send_activation', null, false))
            {
                $this->session->setFlashdata('notice',
                    alert_notice(
                        _lang('your_account_is_not_verified',[my_config('site_name')]) . 
                        $this->util->set_form('verification_form', '!btn btn-success', _lang('request_verification'), NULL, [
                            'verify' => $this->user_id()
                    ])->quickForm($this->user_id(), 'verify'), 'error', FALSE, FALSE, NULL, _lang('verification_required'))
                );

                $now_time   = new DateTime(date('Y-m-d H:i:s', time()));
                $past_time  = new DateTime(date('Y-m-d H:i:s', logged_user('last_update')));
                $time_diff  = $now_time->diff($past_time);  

                $minute_diff = ($time_diff->days * 24 * 60) + ($time_diff->h * 60) + $time_diff->i;  

                // Check if the user is attempting to verify
                if ($request->getPost('verify')) 
                { 
                    if ($minute_diff >= my_config('token_lifespan', null, 5)) 
                    {
                        $act = welcomeEmail(logged_user('username'), 'activation', false);
                        $this->session->setFlashdata('notice', alert_notice($act['message'], $act['status'], FALSE, FALSE, NULL, 'Notice')); 
                    }
                    else
                    {
                        $this->session->setFlashdata('notice', alert_notice(_lang('token_already_sent',[my_config('token_lifespan', null, 5)-$minute_diff]), 'info', FALSE, FALSE, NULL, 'Notice'));
                    }
                    
                    return redirect()->to(base_url('user/account')); 
                }
                // Check if the user has provided a token
                elseif ($request->getGet('token')) 
                {  
                    return $this->no_info_verify();
                }

                return redirect()->to(base_url('user/account'));
            }

            return true;
        }
    }
 
    public function logged_in()
    {     
        $username = $this->session->get('username') ?? get_cookie('username');
        return (bool) $username and $this->usersModel->user_by_username($username); 

    } 

    public function is_logged_in()
    {
        if ($this->session->get('username') or get_cookie('username')) 
        {
            $_user = ($this->session->get('username') ?? get_cookie('username'));
            $user  = $this->usersModel->user_by_username($_user); 
            if (!$user) 
            {
                return redirect()->to(base_url('login'));
            } 
            else 
            {
                return true;
            }
        } 
        else 
        {
            $this->session->set('redirect_to', current_url());
            return redirect()->to(base_url('login'));
        }
    } 

    public function user_redirect($goto = null)
    {
        $request  = \Config\Services::request();  

        if ($this->session->has('username') OR get_cookie('username')) 
        {
            $_user = ($this->session->get('username') ?? get_cookie('username'));
            $user  = $this->usersModel->user_by_username($_user); 
            if (!empty($user)) 
            { 
                if (!empty($goto)) 
                {
                    return redirect()->to(base_url($goto)); 
                }
                return redirect()->to(base_url('dashboard'));   
            }
            else 
            { 
                return redirect()->to(base_url('login'));
            }
        } 
        else 
        { 
            return redirect()->to(base_url('login'));
        }
    } 

    public function fetch($id = null)
    {     
        $data = $this->usersModel->get_user($id);  

        if (!empty($data['uid'])) 
        {   
            $data['lastname'] = $data['middlename'] = ''; 

            if (!empty($data['fullname'])) 
            {
                $name = explode(' ', $data['fullname']);
                if (!empty($name[0])) 
                {
                    $data['firstname'] = $name[0];
                }
                if (!empty($name[1])) 
                {
                    $data['lastname']  = $name[1];
                }
                if (!empty($name[2])) 
                {
                    $data['middlename'] = $name[2];
                }
            } 
            else
            { 
                $data['fullname']  = $data['username'];
                $data['firstname'] = $data['username'];
            }
 
            $data['admin_avatar_link']  = $this->creative->fetch_image('','boy');

            $data['profile_link'] = site_url('user/account/profile/' . $data['uid']);
            $data['avatar_link']  = $this->creative->fetch_image($data['avatar'],'boy'); 
            $data['avatar']       = 
                '<img class="img-size-50 thumbnail img-circle" src="' . $this->creative->fetch_image($data['avatar'],'boy') . '"/>';

            return $data;
        } 
    }

    public static function logout()
    { 
        $account_data = new \App\Libraries\Account_Data;
        return $account_data->user_logout('home');
    }

    public function user_logout($redirect = null)
    {    
        $this->session->remove(['uid', 'username', 'fullname', 'access_folder']);
        $this->session->destroy();

        $url_parts = parse_url(current_url());
        $domain    = '.' . str_replace('www.', '', $url_parts['host']);

        delete_cookie('username', $domain);
        delete_cookie('uid', $domain);

        if ($redirect) 
        {
            return redirect()->to(base_url($redirect));
        }
    } 

    public function user_login($user, $remember = 0)
    {   
        $request = \Config\Services::request();  
        $data = $this->usersModel->get_user($user);  

        $access_folder = ($data['admin'] > 0) ? 'admin' : 'user';
        $_data = array(
            'uid'           => $data['uid'],
            'username'      => $data['username'],
            'fullname'      => $data['fullname'] 
        ); 

        // Save the user's IP address every time they log in
        $this->usersModel->save_user(['uid'=>$data['uid'],'uip'=>$request->getIPAddress()]); 

        $this->session->set($_data);

        if ($remember) 
        {
            $url_parts = parse_url(current_url());
            $domain    = '.' . str_replace('www.', '', $url_parts['host']);
            // set_cookie('username', $_data['username'], time() + (10 * 365 * 24 * 60 * 60), $domain);
        }
    }     


    public function days_diff($far_date = NULL, $close_date = NULL, $units = 'days')
    {   
        if ( ! is_numeric($far_date) ) 
        {
            $far_date = strtotime($far_date);
        }

        if ( ! is_numeric($close_date) ) 
        {
            $close_date = strtotime($close_date);
        }

        $far_date   = $far_date ? date('Y-m-d H:i:s', $far_date) : date('Y-m-d H:i:s', strtotime('tomorrow'));
        $close_date = $close_date ? date('Y-m-d H:i:s', $close_date) : date('Y-m-d H:i:s', strtotime('NOW'));

        $far_date   = new DateTime($far_date);
        $close_date = new DateTime($close_date);   
        $diff       = $far_date->diff($close_date);  
 
        $minutes  = $diff->days * 24 * 60; 
        $minutes += $diff->h * 60; 
        $minutes += $diff->i;
        
        $return_difference = $diff->days; 

        if ($units == 'days') 
        {
            $return_difference = $diff->days; 
        }
        elseif ($units == 'hours')
        {
            $return_difference = $diff->h; 
        }
        elseif ($units == 'minutes') 
        {
            $return_difference = $minutes; 
        }

        return $return_difference; 
    }

}
