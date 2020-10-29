<?php namespace App\Controllers;  

class User extends BaseController
{
	public function index($tab = 'profile', $uid = null)
	{ 
		// Check and redirect if this module is unavailable for the current  theme
		if (!module_active('dashboard')) return redirect()->to(base_url('user/account')); 

		// Check and redirect if this user does not exist
		if (!account_access(user_id(), true)) return account_access(user_id()); 

		$userdata  = $this->account_data->fetch(user_id());
		$view_data = array(
			'session' 	 => $this->session,
			'user' 	     => $userdata,  
			'page_title' => 'Your Dashboard',
			'page_name'  => 'dashboard',   
			'set_folder' => 'user/',
			'statistics' => $this->statsModel->get(['uid' => user_id()]),
			'acc_data'   => $this->account_data,
			'util'       => $this->util,
			'creative'   => $this->creative
		);  

		return theme_loader($view_data); 
	}   

	public function account($tab = 'profile', $uid = null)
	{
		// Check and redirect if this module is unavailable for the current  theme
		if (!module_active('account')) return redirect()->to(base_url('/'));

		$profile  = $this->account_data->fetch(user_id($uid));

		// Check and redirect if this user does not exist
		if (!account_access($profile['uid'], true)) return account_access($profile['uid']); 

		$userdata  = $this->account_data->fetch(user_id());
		$view_data = array(
			'session' 	 => $this->session,
			'user' 	     => $userdata, 
			'uid' 	     => $uid,
			'page_title' => 'Account ' . ucwords($tab),
			'page_name'  => 'account',  
			'tab'  		 => $tab,  
			'_page_name' => $tab,
			'set_folder' => 'user/',
			'statistics' => $this->statsModel->get(['uid' => user_id($uid)]),
			'acc_data'   => $this->account_data,
			'util'       => $this->util,
			'creative'   => $this->creative 
		);  
 
		if ($tab === 'settings' && $this->request->getPost()) 
		{
    		$post_data = $this->request->getPost();

			$req_pass = !empty($post_data['password']) ? 'required|min_length[8]|strong_password' : 'trim';

	        if ($this->validate([
			    'email' => [
			    	'label'  => 'Email Address', 'rules' => "is_unique[users.email,uid,{$profile['uid']}]",
			    	'errors' => [
			    		'valid_email' => 'Validation_.email.valid_email',
			    		'is_unique' => 'Validation_.email.is_unique'
			    	]
			    ], 
			    'phone_number' => [
			    	'label' => 'Phone Number', 'rules' => "is_unique[users.phone_number,uid,{$profile['uid']}]",
			    	'errors' => ['is_unique' => 'Validation_.phone_number.is_unique']
				], 
			    'fullname' => ['label' => 'Fullname', 'rules' => 'alpha_space|min_length[6]'], 
				'password' => ['label' => 'Password', 'rules' => $req_pass] 
			]))
	        {
    			$post_data['uid'] = $profile['uid'];

    			// Change the webmail password
    			if (!empty($post_data['password'])) 
    			{
	    			if ($profile['cpanel']) 
	    			{
	    				$args = [
	    					'email' => $profile['username'], 
	    					'password' => $post_data['password'], 
	    					'domain' => my_config('cpanel_domain')
	    				];
	    				Cpanel(my_config('cpanel_protocol'))->GET->Email->passwd_pop($args);
	    			}

    				$post_data['password'] = $this->enc_lib->passHashEnc($post_data['password']);
    			}
    			
	        	$this->usersModel->save_user($post_data);
	        	$this->session->setFlashdata('notice', alert_notice('Profile Saved!', 'success', FALSE, 'FLAT'));
	        } 
	        else
	        {
	        	$this->session->setFlashdata('notice', $this->form_validation->listErrors('my_error_list')); 
	        } 
		}

		return theme_loader($view_data); 
	}   


    /**
     * This methods handles all products management functions 
     * @param  string 	$action 	Determines the action to take on the product
     * @param  string 	$uid 	 	The id of the a product to manage or view
     * @return string           	Uses the themeloader() to call and return codeigniter's view() method to render the page
     */
	public function products()
	{
		// Check and redirect if this module is unavailable for the current  theme
		if (!module_active('products')) return redirect()->to(base_url('user/account'));

		$userdata  = $this->account_data->fetch(user_id());
		$view_data = array(
			'session'      => $this->session,
			'user' 	       => $userdata,
			'page_title'   => 'Products',
			'page_name'    => 'products',
			'user_product' => true,
			'has_table'    => true,
			'set_folder'   => 'user/',
			'table_method' => 'products/' . user_id(),
			'acc_data'     => $this->account_data,
			'creative'     => $this->creative,
			'products'     => $this->products_m->get() 
		);  

		return theme_loader($view_data); 
	} 


    /**
     * This methods handles all admin hub management functions 
     * @param  string 	$action 	Determines the action to take on the features
     * @param  string 	$id 	 	The id of the hub to handle
     * @return string           Uses the themeloader() to call and return codeigniter's view() method to render the page
     */
	public function hubs($action = 'list', $id = '')
	{
		// Check and redirect if this module is unavailable for the current  theme
		if (!module_active('hubs')) return redirect()->to(base_url('user/account'));

		$userdata  = $this->account_data->fetch(user_id());
		$view_data = array(
			'session' 	 => $this->session,
			'user' 	     => $userdata,
			'page_title' => 'Hubs',
			'page_name'  => 'hubs',  
			'action'     => $action,   
			'set_folder' => 'user/',
			'acc_data'   => $this->account_data,
			'creative'   => $this->creative,
			'hubs'	     => $this->hubs_m->get_hub(),
			'users'      => $this->usersModel->get() 
		);
		
		if ($action === 'detail') 
		{
			$view_data['hub'] = $this->hubs_m->get_hub(['id' => $id]);
			$view_data['page_name']  = 'hub_info'; 
			$view_data['page_title'] = "Hubs ({$view_data['hub']['name']})"; 
		}
		elseif ($action === 'my_hubs')
		{ 
			$view_data['hubs'] = $this->bookings_m->get_all(['uid' => user_id(), 'status' => 1]);
			$view_data['booking_pg'] = $this->bookings_m->pager;
			$view_data['page_name']  = 'hubs_booked'; 
			$view_data['page_title'] = 'My Hubs'; 
		}
		elseif ($action === 'booked')
		{ 
			$view_data['hub'] = $this->bookings_m->get_all(['uid' => user_id(), 'id' => $id, 'status' => 1]);
			$hub_name         = $view_data['hub']['name']??''; 
			$view_data['page_title']  = "Booked Hub ({$hub_name})"; 
			$view_data['screen']      = 'booked'; 
			$view_data['screen_name'] = $hub_name; 
			$view_data['page_name']   = 'hub_booked'; 
			return theme_loader($view_data, 'frontend/basic', 'front'); 
		}

		return theme_loader($view_data); 
	}  


    /**
     * This methods handles all payment management functions 
     * @param  string 	$action 	Determines the action to take on the payment
     * @param  string 	$uid 	 	The id of the a payment to manage or view
     * @return string           	Uses the themeloader() to call and return codeigniter's view() method to render the page
     */
	public function payments($action = "list", $id = '')
	{
		// Check and redirect if this module is unavailable for the current  theme
		if (!module_active('payments')) return redirect()->to(base_url('user/account'));

		$userdata  = $this->account_data->fetch(user_id());
		$view_data = array(
			'session'      => $this->session,
			'user' 	       => $userdata,
			'page_title'   => 'Payments',
			'page_name'    => 'payments', 
			'has_table'    => true,
			'set_folder'   => 'user/',
			'table_method' => 'payments/' . user_id(),
			'acc_data'     => $this->account_data 
		);  
		
		if ($action === 'success') 
		{
			$view_data['page_title'] = "Payment Success"; 
			$view_data['screen']     = 'payment_success'; 
			$view_data['screen_name'] = "Payment Success"; 
			$view_data['page_name']  = 'payment_info'; 

		    if ($this->request->getGetPost('id') && $this->request->getGetPost('type') === 'hub') 
		    { 
		   		$view_data['payment'] = $pmt = $this->bookings_m->get_all(['uid' => user_id(), 'id' => $this->request->getGetPost('id'), 'status' => 1]); 
		   		$view_data['link'] = site_url("user/hubs/booked/{$pmt['id']}"); 
		   		$view_data['message'] = _lang("hub_payment_completed"); 

		   	}

			return theme_loader($view_data, 'frontend/basic', 'front'); 
		}

		return theme_loader($view_data); 
	} 
}
