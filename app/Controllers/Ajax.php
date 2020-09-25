<?php namespace App\Controllers;

use DateTime;

class Ajax extends BaseController
{    

	public function index()
	{
		return $this->response->setJSON([my_config('site_name')]);
	}

	/**
	 * Configuration settings for the site, 
	 * if istantated from an ajax request
	 * @return json response to send to the client
	 */
	public function site_settings()
	{
		// Check if user is logged in and the method is accessed via ajax
		if ($this->util::loggedInIsAJAX() !== true)
			return $this->util::loggedInIsAJAX();
		
	    $data['success'] = false;
	    $data['status']  = 'error';
	    $data['message'] = _lang('an_error_occurred'); 

		$post_data = $this->request->getPost();

	    if (logged_user('admin')>=3) 
	    {
			$save = array($post_data['setting_key'] => $post_data['setting_value']);
			if ($this->settingModel->save_settings($save)) 
			{
		    	$msg = ucwords(str_ireplace(['des','_'], ['', ' '], $post_data['setting_key'].' Settings Updated!'));
		    	$data['success'] = true;
		    	$data['status']  = 'success';
		    	$data['message'] = $msg;
			}
		}

		return $this->response->setJSON($data);
	}      


	/**
	 * Manages tokens
	 * @return json response to send to the client
	 */
	public function token_management()
	{
		// Check if user is logged in and the method is accessed via ajax 

	    $data['success'] = false;
	    $data['status']  = 'error';
	    $data['message'] = _lang('an_error_occurred');

        $validation =  \Config\Services::validation();
        $email      = \Config\Services::email();

		$post_data  = $this->request->getPost();  
		$token 		= sha1(date('Y-m-d H:i:s', time()).rand());

		$subject = $message = '';

	    if ($post_data) 
	    { 
	    	if ($this->request->getPost('action') == 'send_token') 
	    	{
		        if ($this->validate([ 
				    'email' => ['rules' => 'required|valid_email'] 
				]))
		        {  
		        	$email_user      = $this->usersModel->user_by_username($this->request->getPost('email'));

		        	if (!empty($email_user['uid'])) 
		        	{ 
				        $now_time   = new DateTime(date('Y-m-d H:i:s', time()));
				        $past_time  = new DateTime(date('Y-m-d H:i:s', $email_user['last_update']));   
				        $time_diff  = $now_time->diff($past_time);  

		        		if ($time_diff->h >= 1 || $time_diff->i >= 5) 
		        		{
		        			$this->usersModel->save_user(['uid'=>$email_user['uid'], 'token'=>$token, 'last_update'=>time()]);

				        	$email->initialize($this->process->email_config());
				        	$email->setFrom(my_config('contact_email'), my_config('site_name'));
				        	$email->setTo($this->request->getPost('email'));

				        	if ($this->request->getPost('type') == 'recover_password') 
				        	{
				        		$link    = 'user/m/password?token=' . $token;
				        		$link_t  = 'Change Password';
				        		$subject = 'Password reset request for ' . $email_user['username'] . ' on ' . my_config('site_name'); 
				        		$message = my_config('email_recovery');
				        	}
							elseif ($this->request->getPost('type') == 'access_token') 
				        	{
				        		$link    = 'user/m/access?token=' . $token;
				        		$link_t  = 'Token Access';
				        		$subject = 'You requested access to ' . $email_user['username'] . ' on ' . my_config('site_name'); 
				        		$message = my_config('email_token');
				        	}
							elseif ($this->request->getPost('type') == 'incognito_token') 
				        	{
				        		$link    = 'user/m/incognito?token=' . $token;
				        		$link_t  = 'Go Incognito';
				        		$subject = 'You requested incognito access to ' . my_config('site_name'); 
				        		$message = my_config('email_incognito');
				        	}
							elseif ($this->request->getPost('type') == 'account_activation' && my_config('send_activation')) 
				        	{
				        		$link    = 'user/m/activation?token=' . $token;
				        		$link_t  = 'Activate your account';
				        		$subject = 'Welcome to ' . my_config('site_name') . ', please activate you account!'; 
				        		$message = my_config('email_activation');
				        	}

				        	$data['message'] = 'Thank You!';

				        	if ($message) 
				        	{ 
					        	$anchor_link = anchor($link);
								$message = $this->process::parse_content(my_config('email_template'), [
									'message' => $this->process::parse_content($message, [ 
										'title'   => $subject, 
										'user'    => $email_user['fullname'],  
										'anchor_link' => $anchor_link, 
										'link'        => site_url($link), 
										'link_title'  => $link_t
									]), 
									'title'   => $subject,
									'user'    => $email_user['fullname'],
									'anchor_link' => $anchor_link,
									'link'        => site_url($link),
									'link_title'  => $link_t
								]);

								$email->setSubject($subject);
								$email->setMessage($message);

								try 
								{
									$email->send(my_config('mail_debug') ? false : true); 
									$email->printDebugger(['headers', 'subject', 'body']); 

					                if (my_config('mail_debug')) 
					                {
					                    $data['message'] = $email->printDebugger(['headers', 'subject']);
					                }
					                else
					                {
					                    $data['message'] = _lang('activation_token_sent');
					                    $data['success'] = true;
					                    $data['status']  = 'success';    
					                }
								} 
								catch (ErrorException $e) {
			        				$data['message'] = $e;
								}
							}
		        		}
		        		else
		        		{
		        			$data['message'] = _lang('token_already_sent',[5]);
						    $data['success'] = true;
						    $data['status']  = 'info';
		        		}
		        	}
	        		else
	        		{
	        			$data['message'] = _lang('unrecognized_email');
					    $data['success'] = true;
					    $data['status']  = 'info';
	        		}
		        }
		        else
		        {
		        	$data['message'] = $validation->listErrors();
		        } 
	    	}
	    	else
	    	{
	        	$tokened = $this->usersModel->user_by_token($this->request->getPost('token'));
	        	if (!$tokened) 
	        	{
	        		$data['message'] = _lang('m_expired_token');
	        	}
	        	elseif ($this->request->getPost('action') == 'change_password') 
	    		{
			        if ($this->validate([  
					    'password' => ['label' => 'New Password', 'rules' => 'required|min_length[4]'],
					    'repassword' => ['label' => 'Repeat Password', 'rules' => 'required|matches[password]'] 
					]))
			        {    
		                $save['uid']          = $tokened['uid'];
		                $save['password']     = $this->enc_lib->passHashEnc($post_data['password']);
		                if ($this->usersModel->save_user($save)) {
		                	$this->usersModel->save_user(['uid'=>$tokened['uid'],'token'=>$token]);
		                	$this->account_data->user_login($tokened['uid']);
		    				$data['redirect'] = site_url('user/dashboard');
		    				$data['success']  = true;
			    			$data['status']   = 'success';
		                    $data['message']  = 'Your password has been changed successfully';
		                } 
			        } 
			        else
			        {
			        	$data['message'] = $validation->listErrors();
			        } 
	    		}
	    	}
		}
 
		return $this->response->setJSON($data);
	} 


	/**
	 * Saves the user's basic account information
	 * @return json response to send to the client
	 */
	public function save_account_managed_changes()
	{
		// Check if user is logged in and the method is accessed via ajax
		if ($this->util::loggedInIsAJAX() !== true)
			return $this->util::loggedInIsAJAX();

	    $data['success'] = false;
	    $data['status']  = 'error';
	    $data['message'] = _lang('an_error_occurred');

	    if (logged_user('admin')>=3) 
	    {
			$post_data = $this->request->getPost(); 
			$uid 	   = ($post_data['uid']) ? $post_data['uid'] : null;
			$post_data['uid'] = user_id($uid);  
			if ($this->usersModel->save_user($post_data)) 
			{
		    	$data['success'] = true;
		    	$data['status']  = 'success';
		    	$data['message'] = 'User properties updated';
			}
	    }
 
		return $this->response->setJSON($data);
	} 


    /**
     * Changes the user password
     * @param  string   $employee_id    Id of the employee to delete
     * @return null                     Redirects to the employee list
     */
    function change_password()
    { 
		// Check if user is logged in and the method is accessed via ajax
		if ($this->util::loggedInIsAJAX() !== true)
			return $this->util::loggedInIsAJAX();
		
    	$data['success'] = false;
	    $data['status']  = 'error';
	    $data['message'] = _lang('an_error_occurred');

        $validation =  \Config\Services::validation();
        $post_data  = $this->request->getPost();  
		$uid 	    = ($post_data['uid']) ? $post_data['uid'] : null;
        $user       = $this->usersModel->get_user(user_id($uid));
 
        if ($post_data) 
        {
	        if ($this->validate([ 
			    'old_password' => ['rules' => 'required|validate_login[password.Old Password]'],
			    'password' => ['label' => 'New Password', 'rules' => 'required|min_length[4]'],
			    're_new_password' => ['label' => 'Repeat New Password', 'rules' => 'required|matches[password]'] 
			]))
	        {    
                $save['uid']          = $user['uid'];
                $save['password']     = $this->enc_lib->passHashEnc($post_data['password']);
                if ($this->usersModel->save_user($save)) {
    				$data['success'] = true;
	    			$data['status']  = 'success';
                    $data['message'] = 'Your password has been changed successfully';
                } 
	        } 
	        else
	        {
	        	$data['message'] = $validation->listErrors();
	        } 
        } 
 
		return $this->response->setJSON($data);      
    }    

	/**
	 * Cancel,Delete the requested items
	 * @return json response to send to the client
	 */
	public function cancel()
	{
		// Check if user is logged in and the method is accessed via ajax
		if ($this->util::loggedInIsAJAX() !== true)
			return $this->util::loggedInIsAJAX();
		
	    $data['success'] = false;
	    $data['status']  = 'error';
	    $data['message'] = _lang('an_error_occurred');

		$post_data = $this->request->getPost(); 

		$model = $post_data['type'] . 'Model';  
		if ($delete = $this->$model->cancel(array_merge($post_data, ['check' => true]))) 
		{
			$message = 'Request Canceled.';
			if (is_array($delete) && !empty($delete['msg'])) 
			{
				$message = $delete['msg'];
			}
			$data['success'] = true;
    		$data['status']  = 'success';
			$data['message'] = $message;
		} 
 
		return $this->response->setJSON($data);
	}   
    

    /**
     * Loads the view dynamically for the upload modal 
     * @return null     Does not return anything but echoes a JSON Object with the response
     */
	public function upload_image()
	{
		// Check if user is logged in and the method is accessed via ajax
		if ($this->util::loggedInIsAJAX() !== true)
			return $this->util::loggedInIsAJAX();
		
		$post_data = $this->request->getPost();

		if ($post_data['endpoint'] == 'pop') 
		{
			$post_data['banks'] = $this->paystack->bankOption();
		}
		
		$data['content'] = theme_loader($post_data, 'frontend/upload_resize_image'); 

		return $this->response->setJSON($data);  
	}  
}
