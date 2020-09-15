<?php namespace App\Controllers;  

class Admin extends BaseController
{
	public function index()
	{
		// Check and redirect if this module is unavailable for the current  theme
		if (!module_active('_dashboard')) return redirect()->to(base_url('/'));

		$userdata  = $this->account_data->fetch(user_id());
		$view_data = array(
			'session' 	 => $this->session,
			'user' 	     => $userdata,
			'page_title' => 'Dashboard',
			'page_name'  => 'dashboard',  
			'set_folder' => 'admin/',
			'statistics' => $this->statsModel->get(),
			'acc_data'   => $this->account_data,
			'util'       => $this->util,
			'creative'   => $this->creative
		);  

		return theme_loader($view_data); 
	}  


    /**
     * This methods handles all user management functions 
     * @param  string 	$action 	Determines the action to take on the users
     * @param  string 	$uid 	 	The user id of the a user to manage or view
     * @return string           Uses the themeloader() to call and return codeigniter's view() method to render the page
     */
	public function users($action = '', $uid = null)
	{
		// Check and redirect if this module is unavailable for the current  theme
		if (!module_active('_users')) return redirect()->to(base_url('admin/dashboard'));

		$userdata  = $this->account_data->fetch(user_id());
		$view_data = array(
			'session' 	 => $this->session,
			'user' 	     => $userdata,
			'page_title' => 'Users',
			'page_name'  => 'users', 
			'has_table'  => true,
			'set_folder' => 'admin/',
			'table_method' => 'users',
			'acc_data'   => $this->account_data,
			'creative'   => $this->creative,
			'users'      => $this->usersModel->get() 
		);

		// Grant admin access to a user's account
		if ($action == 'access' && $uid) 
		{
			$token = sha1(date('Y-m-d H:i:s', time()).rand());
			$this->usersModel->save_user(['uid'=>$uid, 'token'=>$token, 'last_update'=>time()]);
			return redirect()->to(base_url('user/m/access?grant=admin&token=' . $token));
		}
		return theme_loader($view_data); 
	} 


    /**
     * This methods handles all products management functions 
     * @param  string 	$action 	Determines the action to take on the product
     * @param  string 	$uid 	 	The id of the a product to manage or view
     * @return string           	Uses the themeloader() to call and return codeigniter's view() method to render the page
     */
	public function products($action = '', $id = null)
	{
		// Check and redirect if this module is unavailable for the current  theme
		if (!module_active('_products')) return redirect()->to(base_url('admin/dashboard'));

		$userdata  = $this->account_data->fetch(user_id());
		$view_data = array(
			'session' 	 => $this->session,
			'user' 	     => $userdata,
			'page_title' => 'Products',
			'page_name'  => 'products', 
			'has_table'  => true,
			'set_folder' => 'admin/',
			'table_method' => 'products',
			'acc_data'   => $this->account_data,
			'creative'   => $this->creative,
			'products'  => $this->products_m->get() 
		);

		if ($action == 'create') 
		{
			$view_data['page_name']  = 'create_product';
			$view_data['_page_name'] = 'products';
			$view_data['action']    = $action;
			$view_data['id']        = $id;
			$view_data['product']   = $this->products_m->find($id);
			$view_data['has_table'] = false;

	        if ($this->request->getPost()) 
	        {
                $save = $this->request->getPost(); 
                
            	($id) ? $save['id'] = $id : null;  

	            // Validate post data
		        $this->validate([
				    'email'  => ['label' => 'Email', 'rules' => 'trim|required|valid_email'],   
				    'domain' => ['label' => 'Domain', 'rules' => "trim|required|valid_url|is_unique[all_products.domain,id,$id]"],   
				    'name'   => ['label' => 'Product Name', 'rules' => 'trim|required'],  
				    'code'   => ['label' => 'Product Code', 'rules' => 'trim|required'] 
				]);

		        // Check for validation errors
		        if ($this->form_validation->run($this->request->getPost()) === FALSE) 
		        { 
		            $this->session->setFlashdata('notice', $this->form_validation->listErrors('my_error_list')); 
		        } 
		        else 
		        { 
		        	$get_user = $this->usersModel->get_user($save['email']); 
		        	if ($get_user) 
		        	{
		        		$save['uid'] = $get_user['uid'];
		        	}
		        	else
		        	{	
			        	$save_user['status']   = 2;
			        	$save_user['email']    = $save['email'];
			        	$save_user['password'] = $this->enc_lib->passHashEnc($save['email']);
			        	$save_user['username'] = $this->account_data->email2username($save['email']);  
			        	$save['uid']           = $this->usersModel->save_user($save_user);
		        	}

		        	$save['name'] = url_title($save['name'], '_', true);
	                // Save the product
	                if ($id = $this->products_m->create($save))
	                	$this->session->setFlashdata('notice', alert_notice("Product Saved", 'success')); 
	                	return redirect()->to(base_url('admin/products/create/'.$id));
	            }
	        }
		}

		// Grant admin access to a user's account
		if ($action == 'access' && $uid) 
		{
			$token = sha1(date('Y-m-d H:i:s', time()).rand());
			$this->usersModel->save_user(['uid'=>$uid, 'token'=>$token, 'last_update'=>time()]);
			return redirect()->to(base_url('user/m/access?grant=admin&token=' . $token));
		}
		return theme_loader($view_data); 
	} 


    /**
     * This methods handles the global configuration of the the whole system
     * @param  string   $step   The configuration forms are broken down into 
     *                          steps for maintainability, this will set the current step   
     * @return string           Uses the themeloader() to call and return codeigniter's view() method to render the page
     */
    public function configuration($step = 'main', $action = '')
    { 
		// Check and redirect if this module is unavailable for the current  theme
		if (!module_active('_config')) return redirect()->to(base_url('admin/dashboard'));

        // Check if the user has permission to access this module and redirect to 401 if not   
		$userdata          = $this->account_data->fetch(user_id()); 
		// $userdata['banks'] = $this->paystack->bankOption($userdata['bank_code']);

        $data = array(
			'session' 	 	=> $this->session,
			'user' 	     	=> $userdata,
			'page_title' 	=> 'Configuration',
			'page_name'  	=> 'configuration',
			'set_folder'    => 'admin/',
			'errors'        => $this->form_validation,
			'creative'      => $this->creative, 
            'request'       => $this->request, 
            'step'          => $this->request->getPost('step') ? $this->request->getPost('step') : $step, 
            'enable_steps'  => 1
        ); 

        // Remove configuration item value
        $q = $this->request->getGet('q');
        if ($action == 'remove' && $q) 
        {
        	$this->settingModel->save_settings([$q=>'']);
	        $this->session->setFlashdata('notice', alert_notice("Configuration Saved", 'success')); 
	        return redirect()->to(base_url('admin/configuration/'.$step.'#'));
        }
 
        if ($this->request->getPost()) 
        {
        	// Validation for main configuration
	        if (!$data['enable_steps'] || $data['step'] == 'main') 
	        {  
		        $this->validate([
				    'value.site_name' => ['label' => 'Site Name', 'rules' => 'trim|required|alpha_numeric_punct'] 
				]);
	        }

	        // Validation for payment configuration
	        if (!$data['enable_steps'] || $data['step'] == 'payment')
	        {    
		        $this->validate([
				    'value.site_currency'   => ['label' => 'Site Currency', 'rules' => 'trim|required|alpha|max_length[3]'],
				    'value.currency_symbol' => ['label' => 'Currency Symbol', 'rules' => 'trim'],
				    'value.payment_ref_pref'=> ['label' => 'Reference Prefix', 'rules' => 'trim|alpha_dash'],
				    'value.paystack_public' => ['label' => 'Paystack Public Key', 'rules' => 'trim|alpha_dash'],
				    'value.paystack_secret' => ['label' => 'Checkout Info', 'rules' => 'trim|alpha_dash']
				]);
	        } 

	        // Validation for system configuration
	        if (!$data['enable_steps'] || $data['step'] == 'system')
	        {    
	        	$require_smtp = ($this->request->getPost('value[email_protocol]') == 'smtp') ? '|required' : null;
	        	$require_sendmail = ($this->request->getPost('value[email_protocol]') == 'sendmail') ? '|required' : null;
		        $this->validate([  
				    'value.smtp_port' => ['label' => 'SMTP Port', 'rules' => 'trim' . $require_smtp], 
				    'value.smtp_host' => ['label' => 'SMTP Host', 'rules' => 'trim' . $require_smtp], 
				    'value.smtp_user' => ['label' => 'SMTP Username', 'rules' => 'trim' . $require_smtp], 
				    'value.smtp_pass' => ['label' => 'SMTP Password', 'rules' => 'trim' . $require_smtp], 
				    'value.smtp_crypto' => ['label' => 'SMTP Encryption', 'rules' => 'trim' . $require_smtp], 
				    'value.mailpath'    => ['label' => 'Mail Path', 'rules' => 'trim' . $require_sendmail]
				]);
	        }

	        // validation for contact configuration
	        if (!$data['enable_steps'] || $data['step'] == 'contact') 
	        {  
		        $this->validate([
				    'value.contact_email'     => ['label' => 'Contact Email', 'rules' => 'trim|valid_emails'],
				    'value.contact_phone'     => ['label' => 'Contact Phone', 'rules' => 'trim'],
				    'value.contact_days'      => ['label' => 'Contact Days', 'rules' => 'trim'],
				    'value.contact_facebook.' => ['label' => 'Contact Facebook', 'rules' => 'trim'],
				    'value.contact_twitter'   => ['label' => 'Contact Twitter', 'rules' => 'trim'], 
				    'value.contact_instagram' => ['label' => 'Contact Instagram', 'rules' => 'trim'], 
				    'value.contact_address'   => ['label' => 'Contact Address', 'rules' => 'trim'] 
				]);
	        }    

	        // Validate configuration input data
	        if ($this->form_validation->run($this->request->getPost()) === FALSE) 
	        { 
	            $this->session->setFlashdata('notice', $this->form_validation->listErrors('my_error_list')); 
	        } 
	        else 
	        { 
	        	// Upload configuration images
	            unset($_POST['step']);
	            $l_resize = ['width'   => 500, 'height' => 500];
	            $f_resize = ['width' => 30, 'height'  => 30];
	            $b_resize = ['width' => 1920, 'height' => 1080];
	            $this->creative->upload('main_banner', my_config('main_banner'), 'main_banner', NULL, $b_resize, ['value' => 'main_banner']); 
	            $this->creative->upload('default_banner', my_config('default_banner'), 'default_banner', NULL, $b_resize, ['value' => 'default_banner']);
	            $t = $this->creative->upload('site_logo', my_config('site_logo'), 'site_logo', NULL, $l_resize, ['value' => 'site_logo']);
	            $this->creative->upload('favicon', my_config('favicon'), 'favicon', NULL, $f_resize, ['value' => 'favicon']);

	            // Check for image upload errors
	            if ($this->creative->upload_errors() === FALSE)
	            {
	            	// Merge image and post data
	                $save = $this->request->getPost('value');
	                if (isset($_POST['creative_lib'])) {
	                	$save = array_merge($save, $_POST['creative_lib']['value']);
	                }

	                // Save the configuration
	                $this->settingModel->save_settings($save);
	                $this->session->setFlashdata('notice', alert_notice("Configuration Saved", 'success')); 
	                return redirect()->to(base_url('admin/configuration/'.$step));
	            }

	            $process_complete = TRUE;
	        } 
        }  
      
        return theme_loader($data);  
    }


    /**
     * This is the default login page
     * @param  string 	$page 	 	Set page to determine login or signup
     * @return string           	Uses the themeloader() to call and return codeigniter's view() method to render the page
     */
	public function login($page = 'login')
	{
		if ($this->account_data->logged_in())
		{
			if ($this->request->getGet('ref')) 
			{
				$this->account_data->user_logout();
			}
			else
			{
				return $this->account_data->user_redirect();
			}
		}

		$view_data = array(
			'session' 	 => $this->session,
			'page_title' => 'Login',
			'page_name'  => $page,
			'util'       => $this->util,
			'creative'   => $this->creative, 
			'errors'     => $this->form_validation
		); 

	    $post_data = $this->request->getPost();
		if ($page === 'login') 
		{  
		    if ($post_data) 
		    {
		        if ($this->validate([
				    'username' => ['rules' => 'required|validate_login[username.Username or Email Address]'],
				    'password' => ['rules' => 'required|validate_login[password.Password]'] 
				]))
		        {
		        	$fetch_user = $this->usersModel->user_by_username($post_data['username']); 
	        		$this->account_data->user_login($fetch_user['uid'], ($this->request->getPost('remember') == 'on'));
					if ($this->account_data->logged_in())
					{
						$previous_url = stripos(previous_url(), 'user/m') ? previous_url() : null; 
						return $this->account_data->user_redirect($previous_url);
					} 
		        }  
		    }
		}
		elseif ($page === 'signup') 
		{
        	$view_data['page_title'] = 'Register'; 

		    if ($post_data) 
		    {
		        if ($this->validate([
				    'email' => [
				    	'label'  => 'Email Address', 'rules' => 'required|valid_email|is_unique[users.email]',
				    	'errors' => [
				    		'valid_email' => 'Validation_.email.valid_email',
				    		'is_unique' => 'Validation_.email.is_unique'
				    	]
				    ],
				    'phone_number' => [
				    	'label' => 'Phone Number', 'rules' => 'required|numeric|is_unique[users.phone_number]',
				    	'errors' => ['is_unique' => 'Validation_.phone_number.is_unique']
					],
				    'password'   => ['label' => 'Password', 'rules' => 'required|min_length[4]'],
				    'repassword' => ['label' => 'Repeat Password', 'rules' => 'required|min_length[4]|matches[password]'],
				    'terms' => [
				    	'label'  => 'Terms and Conditions', 'rules' => 'required', 
				    	'errors' => [ 'required' => 'Validation_.terms.accept_terms']
				    ] 
				]))
		        {
		        	$post_data['password'] = $this->enc_lib->passHashEnc($post_data['password']);
		        	$post_data['username'] = $this->account_data->email2username($post_data['email']);  

		        	if ($insert_id = $this->usersModel->save_user($post_data)) 
		        	{	
		        		$this->account_data::set_referrer(false);
		        		$this->account_data->user_login($insert_id);
						if ($this->account_data->logged_in())
						{
							return $this->account_data->user_redirect('user/welcome');
						}
		        	}
		        }
		    }
		} 
		return theme_loader($view_data, 'frontend/login');
	}

    /**
     * Triggers the logout event and redirects to the homepage
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
	public function logout()
	{
		\CodeIgniter\Events\Events::trigger('logout');
		// return redirect()->to(base_url('home'));
		// return $this->account_data->user_logout('home');
	} 
}
