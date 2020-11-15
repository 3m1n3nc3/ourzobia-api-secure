<?php namespace App\Controllers\Ajax;

use App\Controllers\BaseController;
use DateTime;

class Main extends BaseController
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
        $util       = new \App\Libraries\Util;

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
		        	$receiver = $this->usersModel->user_by_username($this->request->getPost('email'));

		        	if (!empty($receiver['uid'])) 
		        	{ 
				        $now_time   = new DateTime(date('Y-m-d H:i:s', time()));
				        $past_time  = new DateTime(date('Y-m-d H:i:s', $receiver['last_update']));   
				        $time_diff  = $now_time->diff($past_time);  

						$minute_diff = ($time_diff->days * 24 * 60) + ($time_diff->h * 60) + $time_diff->i; 

		        		if ($minute_diff >= my_config('token_lifespan', null, 5)) 
		        		{
            				$data['message'] = _lang('activation_token_sent');

				        	if ($this->request->getPost('type') == 'recover_password') 
				        	{
				        		$link    = 'user/m/password?token=' . $token;
				        		$link_t  = 'Change Password';
				        		$subject = 'Password reset request for ' . $receiver['username'] . ' on ' . my_config('site_name'); 
				        		$message = my_config('email_recovery');
				        	}
							elseif ($this->request->getPost('type') == 'access_token') 
				        	{
				        		$link    = 'user/m/access?token=' . $token;
				        		$link_t  = 'Token Access';
				        		$subject = 'You requested access to ' . $receiver['username'] . ' on ' . my_config('site_name'); 
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

					        if (!empty($message)) 
					        { 
					            // Send the mail now 
					            $data = $util::sendMail([
					                'subject'  => $subject,
					                'message'  => $message,
					                'link'     => $link,
					                'link_t'   => $link_t,
					                'receiver' => $receiver,
					                'success'  => $data['message'],
					            ]);

					            if (($data['success']??false) === true) 
					            {
		        					$this->usersModel->save_user([
		        						'uid' => $receiver['uid'], 'token' => $token, 'last_update'=>time()
		        					]); 
					            }
					        }
		        		}
		        		else
		        		{
		        			$data['message'] = _lang('token_already_sent',[my_config('token_lifespan', null, 5)-$minute_diff]);
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
		                if ($this->usersModel->save_user($save)) 
		                {
		                	$this->usersModel->save_user(['uid'=>$tokened['uid'],'token'=>$token]);
		                	$this->account_data->user_login($tokened['uid']);
			    			if (my_config('cpanel_domain') && $tokened['cpanel']) 
			    			{ 
			    				Cpanel(my_config('cpanel_protocol'))->GET->Email->passwd_pop([
			    					'email'    => $tokened['username'], 
			    					'password' => $save['password'], 
			    					'domain'   => my_config('cpanel_domain')
			    				]);
			    			}
		    				$data['redirect'] = site_url('user/dashboard');
		    				$data['success']  = true;
			    			$data['status']   = 'success';
		                    $data['message']  = 'Your password has been changed successfully, please wait...';
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

		$model = (stripos($post_data['type'], "_model") !== false) ? str_replace("model", "m", $post_data['type']) : $post_data['type'] . "Model";  
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
    

    /**
     * Loads the view dynamically to write a new post
     * @return null     Does not return anything but echoes a JSON Object with the response
     */
	public function upload_media_modal($segment = 'user')
	{
		// Check if user is logged in and the method is accessed via ajax
		if ($this->util::loggedInIsAJAX() !== true)
			return $this->util::loggedInIsAJAX();
		
		$post_data = $this->request->getPost();
		$content_type = $this->request->getPost('type');

		$data['success'] = true;
		$data['status']  = 'success';
		$data['html']    = load_widget('content/gallery_upload_form', ['segment'=>$segment, 'content_type'=>$content_type]); 

		return $this->response->setJSON($data);  
	} 
    

    /**
     * Loads the view dynamically to write a new post
     * @return null     Does not return anything but echoes a JSON Object with the response
     */
	public function just_load_modal($modal = 'payment_processor')
	{ 		
		$post_data = $this->request->getGetPost(); 

		$data['success'] = true;
		$data['status']  = 'success';
		$data['html']    = load_widget('content/' . $modal . '_modal', ['post_data' => $post_data]); 
		$data['body']['html'] = load_widget('content/js_payment_processor_widget', ['load' => 1]);
		$data['body']['id']   = '#payment-processor-widget';

		return $this->response->setJSON($data);  
	} 

	/**
	 * Send Emails and subscribe to marketing
	 * @return json response to send to the client
	 */
	public function marketing_form()
	{ 
	    $data['success'] = false;
	    $data['status']  = 'error';
	    $data['message'] = _lang('an_error_occurred'); 

		if ($this->request->isAJAX())
		{
        	$validation =  \Config\Services::validation();
        	$util       = new \App\Libraries\Util;

			$post_data = $this->request->getPost();
			if ($post_data['type'] === 'message') 
			{
		        if ($this->validate([ 
				    'first_name' => ['label' => 'First Name', 'rules' => 'trim|required'],
				    'last_name' => ['label' => 'Last Name', 'rules' => 'trim|required'],
				    'email' => ['label' => 'Email Address', 'rules' => 'trim|required|valid_email'],
				    'message' => ['label' => 'Message', 'rules' => 'trim|required|min_length[20]'] 
				]))
		        {     
				    $data = $util::sendMail([
		                'subject'  => "New message from {$post_data['first_name']} {$post_data['last_name']} on " . my_config('site_name'),
		                'message'  => _lang('contact_form_email_template', [
		                	my_config('site_name'), 
		                	"{$post_data['first_name']} {$post_data['last_name']}", 
		                	$post_data['email'], 
		                	$post_data['phone'], 
		                	$post_data['message']
		                ]), 
		                'receiver' => [
		                	'email' => my_config('contact_email'), 
		                	'fullname' => my_config('site_name')
		                ],
		                'success'  => _lang('message_sent'),
		            ]); 
		        } 
		        else
		        {
		        	$data['message'] = $validation->listErrors();
		        } 
			}
			elseif ($post_data['type'] === 'subscribe') 
			{
		        if ($this->validate([  
				    'email' => ['label' => 'Email Address', 'rules' => 'trim|required|valid_email']  
				]))
		        {     
				    $subscribe = \Config\Services::mailjet_subscribe(my_config('mailjet_api_key'), my_config('mailjet_secret_key'), [$post_data['email']], my_config('mail_debug'));
        			if ($subscribe === true)
        			{
					    $data['success'] = true;
					    $data['status']  = 'success';
					    $data['message'] = _lang('subscription_was_successful');
        			}
        			else
        			{
					    $data['message'] = $subscribe;
        			}
		        } 
		        else
		        {
		        	$data['message'] = $validation->listErrors();
		        }
			}
		}

		return $this->response->setJSON($data);
	}   
}
