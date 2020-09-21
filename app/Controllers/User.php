<?php namespace App\Controllers;  

class User extends BaseController
{
	public function index($tab = 'profile', $uid = null)
	{ 
		// Check and redirect if this module is unavailable for the current  theme
		if (!module_active('dashboard')) return redirect()->to(base_url('/')); 

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
			    'fullname' => ['label' => 'Fullname', 'rules' => 'alpha_space|min_length[6]'] 
			]))
	        {
    			$post_data        = $this->request->getPost();
    			$post_data['uid'] = $profile['uid'];
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
		if (!module_active('_products')) return redirect()->to(base_url('admin/dashboard'));

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
 
}
