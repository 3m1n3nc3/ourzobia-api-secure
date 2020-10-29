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
			'show_stats' => true,
			'statistics' => $this->statsModel->get(),
			'acc_data'   => $this->account_data,
			'util'       => $this->util,
			'creative'   => $this->creative
		);  

		return theme_loader($view_data, null, 'admin'); 
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
		elseif ($action === 'create') 
		{
			$view_data['page_name'] = 'create_users';
			$view_data['_page_name'] = 'users';

	        if ($this->request->getPost()) 
	        {
		        if ($this->validate([
				    'email' => [
				    	'label'  => 'Email Address', 'rules' => "is_unique[users.email]",
				    	'errors' => [
				    		'valid_email' => 'Validation_.email.valid_email',
				    		'is_unique'   => 'Validation_.email.is_unique'
				    	]
				    ],
				    'username' => [
				    	'label'  => 'Username', 'rules' => "required|alpha_numeric_punct|is_unique[users.username]|min_length[6]",
				    	'errors' => ['is_unique' => 'Validation_.username.is_unique']
				    ], 
				    'phone_number' => [
				    	'label'  => 'Phone Number', 'rules' => 'is_unique[users.phone_number]',
				    	'errors' => ['is_unique' => 'Validation_.phone_number.is_unique']
					],
				    'fullname' => ['label' => 'Fullname', 'rules' => 'alpha_space|min_length[6]'], 
				    'password' => ['label' => 'Password', 'rules' => 'required|min_length[4]|strong_password'] 
				]))
		        {
	    			$post_data = $this->request->getPost();
	    			if (!empty($uid)) 
	    				$post_data['uid']  = $uid;
	    			$post_data['password'] = $this->enc_lib->passHashEnc($post_data['password']);

		        	$this->usersModel->save_user($post_data);
	        		$this->session->setFlashdata('notice', alert_notice('Profile Saved!', 'success', FALSE, 'FLAT'));
		        }
		        else
		        {
		        	$this->session->setFlashdata('notice', $this->form_validation->listErrors('my_error_list')); 
		        }
	        } 
		}

		return theme_loader($view_data, null, 'admin'); 
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
			'products'  => $this->products_m->get(),
			'validate'   => $this->form_validation
		);

		if ($action == 'create') 
		{
			$view_data['page_name']  = 'create_product';
			$view_data['_page_name'] = 'products';
			$view_data['action']    = $action;
			$view_data['id']        = $id;
			$view_data['product']   = $this->products_m->where('id', $id)->get()->getRowArray();
			$view_data['has_table'] = false;

	        if ($this->request->getPost()) 
	        {
                $save = $this->request->getPost(); 
                
            	($id) ? $save['id'] = $id : null;
            	$require_domain     = (!empty($view_data['product']['domain'])) ? '|valid_url|required' : '';
            	$empty_domain       = ($this->request->getPost('domain')) ? '|is_unique[all_products.domain,id,$id]' : '';

	            // Validate post data
		        $this->validate([
				    'email'  => ['label' => 'Email', 'rules' => 'trim|required|valid_email'],   
				    'domain' => ['label' => 'Domain', 'rules' => "trim" . $empty_domain . $require_domain],   
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
 
		return theme_loader($view_data, null, 'admin'); 
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
		// 
		$pagination = $this->request->getGet('page');

        $data = array(
			'session' 	 	=> $this->session,
			'user' 	     	=> $userdata,
			'page_title' 	=> 'Configuration',
			'page_name'  	=> 'configuration',
			'pagination'	=> $pagination ?? 1,
			'set_folder'    => 'admin/',
			'errors'        => $this->form_validation,
			'creative'      => $this->creative, 
            'request'       => $this->request, 
            'step'          => $this->request->getPost('step') ? $this->request->getPost('step') : $step, 
            'enable_steps'  => 1
        ); 

        // Update the .env file
        if (!empty($this->request->getPost('env')))  
        	update_env($this->request->getPost('env')); 

        // Update timezone
        if ($this->request->getPost('timezone'))
            update_env(["appTimezone" => $this->request->getPost('timezone')]);

        // Remove configuration item value
        $q = $this->request->getGet('q');
        if ($action == 'remove' && $q) 
        {
        	// load the view here to avoid page redirect or refresh
        	$this->settingModel->save_settings([$q=>'']);
	        $this->session->setFlashdata('notice', alert_notice("Configuration Saved", 'success')); 
	        return redirect()->to(base_url('admin/configuration/'.$step.'#'));
        }
 
        if ($this->request->getPost()) 
        { 
	        if ($this->request->getPost("find_lang_string") || $this->request->getPost("clear_all"))
	        {
	        	return theme_loader($data, null, 'admin');  
	        }

        	// Validation for main configuration
	        if (!$data['enable_steps'] || $data['step'] == 'main') 
	        {
		        $this->validate([
				    'value.site_name' => ['label' => 'Site Name', 'rules' => 'trim|required|alpha_numeric_punct'],
				    'value.default_password' => ['label' => 'Default Email Password', 'rules' => 'trim|strong_password'] 
				]);
	        }

	        // Validation for payment configuration
	        if (!$data['enable_steps'] || $data['step'] == 'payment')
	        {    
		        $this->validate([
				    'value.site_currency'   => ['label' => 'Site Currency', 'rules' => 'trim|required|alpha|max_length[3]'],
				    'value.currency_symbol' => ['label' => 'Currency Symbol', 'rules' => 'trim'],
				    'value.payment_ref_pref'=> ['label' => 'Reference Prefix', 'rules' => 'trim|alpha_dash'],
				    'value.paystack_public' => ['label' => 'Paystack Public Key', 'rules' => 'trim'],
				    'value.paystack_secret' => ['label' => 'Paystack Secret Key', 'rules' => 'trim']
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
	 		
	 		// Validation for design configuration
	        if (!$data['enable_steps'] || $data['step'] == 'design') 
	        {  
		        $this->validate([
				    'value.des_fixed_layout' => ['label' => 'Layout', 'rules' => 'trim'] 
				]);
	        } 
	 		
	 		// Validation for design configuration
	        if (!$data['enable_steps'] || $data['step'] == 'translations') 
	        {  
		        $this->validate([
				    'value.des_fixed_layout' => ['lang_pack' => 'Translations Pack', 'rules' => 'trim'] 
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
	                $save = $this->request->getPost('value');
	                
	            	// Don't overwrite passwords
	                if (empty($save['cpanel_password']))
		                unset($save['cpanel_password']);

	                if (empty($save['afterlogic_password']))
		                unset($save['afterlogic_password']);

	            	// Merge image and post data
	                $save = $this->request->getPost('value');
	                if (isset($_POST['creative_lib'])) {
	                	$save = array_merge($save, $_POST['creative_lib']['value']);
	                }

	                // Update the language file
	                if ($this->request->getPost('save_update'))  
	                {
        				save_lang(my_config('lang_pack', null, 'Default_'), $this->request->getPost('lang'));
	                }

	                // Generate a language file
	                if ($this->request->getPost('gen_trans'))  
	                {
        				save_lang('Default_', [], $this->request->getPost('env[app.defaultLocale]'));
	                }

	                // Delete a language file
	                if ($this->request->getPost('delete_lang'))  
	                {
        				delete_lang($this->request->getPost('value[lang_pack]'));
	                }

	                // Save the configuration
					$pagged = $this->request->getPost('pagination');
	                $saved  = $this->settingModel->save_settings($save);
	                $msg    = (!empty($saved['msg'])) ? alert_notice($saved['msg'], 'error') : alert_notice("Configuration Saved", 'success');
	                $this->session->setFlashdata('notice', $msg); 
	                _redirect(base_url('admin/configuration/' . $step . ($pagged>1 ? '?page='.$pagged : '')), 'location');
	            }

	            $process_complete = TRUE;
	        } 
        }  
      
        return theme_loader($data, null, 'admin');  
    }


    /**
     * This methods handles all admin feature management functions 
     * @param  string 	$action 	Determines the action to take on the features
     * @param  string 	$id 	 	The id of the feature to handle
     * @return string           Uses the themeloader() to call and return codeigniter's view() method to render the page
     */
	public function features($action = 'list', $id = '')
	{
		// Check and redirect if this module is unavailable for the current  theme
		if (!module_active('_features')) return redirect()->to(base_url('admin/dashboard'));

		$userdata  = $this->account_data->fetch(user_id());
		$feature   = $this->contentModel->get_features(['id' => $id]);
		$view_data = array(
			'session' 	 => $this->session,
			'user' 	     => $userdata,
			'page_title' => 'Features',
			'page_name'  => 'features',  
			'action'     => $action,  
			'set_folder' => 'admin/',
			'acc_data'   => $this->account_data,
			'creative'   => $this->creative,
			'features'	 => $this->contentModel->get_features(),
			'users'      => $this->usersModel->get() 
		);

		// Create new features
		if ($action == 'create') 
		{
			$view_data['id']         = $id;
			$view_data['feature']    = $feature;
			$view_data['page_name']  = 'create_feature';
			$view_data['_page_name'] = 'features';

	        if ($this->request->getPost()) 
	        {
	        	// Upload image
	        	$image = ($id) ? $view_data['feature']['image'] : ''; 
	        	$require_img = '';
	        	if ($this->request->getPost('type') === 'slider') 
	        	{
	        		$banner_size = ['width'   => 1650, 'height' => 650];
	        		if (!$image) $require_img = '|uploaded[image]|is_image[image]'; 
	        	}
	        	else
	        	{
	        		$banner_size = ['width'   => 284, 'height' => 180];
	        	}

		        $this->validate([
				    'title'   => ['label' => 'Title', 'rules' => 'trim|required'],
				    'details' => ['label' => 'Details', 'rules' => 'trim|required'],
				    'image' => [
				    	'label' => 'Banner Image', 'rules' => 'trim' . $require_img,
				    	'errors' => [
				    		'uploaded' => 'Validation_.uploaded' 
				    	]
				    ]
				]);

		        // Validate configuration input data
		        if ($this->form_validation->run($this->request->getPost()) === FALSE) 
		        { 
		            $this->session->setFlashdata('notice', $this->form_validation->listErrors('my_error_list')); 
		        } 
		        else 
		        {   
		        	if ($this->request->getFile('image')->isValid()) 
		        	{
		            	$this->creative->upload('image', $image, NULL, NULL, $banner_size, 'image');  
		        	}

		            // Check for upload errors
		            if ($this->creative->upload_errors() === FALSE)
		            {
		                $save = $this->request->getPost(); 
		                
		            	($id) ? $save['id'] = $id : null; 

		            	// Merge image and post data
		                if (isset($_POST['creative_lib'])) {
		                	$save = array_merge($save, $_POST['creative_lib']);
		                } 

		                // Create feature
		                if ($id = $this->contentModel->save_features($save))
		                	$this->session->setFlashdata('notice', alert_notice("Feature Saved", 'success')); 
		                	return redirect()->to(base_url('admin/features/create/'.$id));
		            }
		        }
	        }
		}

		// Delete feature
		if ($action == 'delete') 
		{ 
			if ($this->contentModel->cancel_feature(['id' => $id]))
				$this->creative->delete_file('./' . $feature['image']);
	            $this->session->setFlashdata('notice', alert_notice("Feature Deleted", 'success')); 
				return redirect()->to(base_url('admin/features/'));
		}
		return theme_loader($view_data, null, 'admin'); 
	} 


    /**
     * This methods handles all admin gallery management functions 
     * @param  string 	$action 	Determines the action to take on the features
     * @param  string 	$id 	 	The id of the gallery item to handle
     * @return string           Uses the themeloader() to call and return codeigniter's view() method to render the page
     */
	public function gallery($action = 'list', $id = '')
	{
		// Check and redirect if this module is unavailable for the current  theme
		if (!module_active('_gallery')) return redirect()->to(base_url('admin/dashboard'));

		$userdata  = $this->account_data->fetch(user_id());
		$gallery   = $this->contentModel->get_features(['id' => $id], 'gallery');
		$view_data = array(
			'session' 	 => $this->session,
			'user' 	     => $userdata,
			'page_title' => 'Gallery',
			'page_name'  => 'gallery',  
			'action'     => $action,  
			'set_folder' => 'admin/',
			'acc_data'   => $this->account_data,
			'creative'   => $this->creative,
			'galleries'	 => $this->contentModel->get_features([], 'gallery'),
			'users'      => $this->usersModel->get() 
		);

		// Create new features
		if ($action == 'create') 
		{
			$view_data['id']         = $id;
			$view_data['gallery']    = $gallery;
			$view_data['page_name']  = 'gallery_add_item';
			$view_data['_page_name'] = 'gallery';

	        if ($this->request->getPost()) 
	        {
	        	// Upload image
	        	$file = ($id) ? $gallery['file'] : ''; 
	        	$require_img = '';
	        	if (!$file) $require_img = '|uploaded[file]|mime_in[file,video/*,image/*]'; 

		        $this->validate([
				    'title'   => ['label' => 'Title', 'rules' => 'trim|required'], 
				    'file' => [
				    	'label' => 'File', 'rules' => 'trim' . $require_img,
				    	'errors' => [
				    		'uploaded' => 'Validation_.uploaded' 
				    	]
				    ]
				]);

		        // Validate configuration input data
		        if ($this->form_validation->run($this->request->getPost()) === FALSE)
		        { 
		            $this->session->setFlashdata('notice', $this->form_validation->listErrors('my_error_list')); 
		        } 
		        else 
		        {   
		        	if ($this->request->getFile('file')->isValid()) 
		        	{
		            	$this->creative->upload('file', $file, NULL, NULL, ['width'   => 700, 'height' => 650], 'file');  
		        	}

		            // Check for upload errors
		            if ($this->creative->upload_errors() === FALSE)
		            {
		                $save = $this->request->getPost(); 
		                
		            	($id) ? $save['id'] = $id : null; 

		            	// Merge file and post data
		                if (isset($_POST['creative_lib'])) {
		                	$save = array_merge($save, $_POST['creative_lib']);
		                } 

		                // Create feature
		                if ($id = $this->contentModel->save_gallery($save))
		                	$this->session->setFlashdata('notice', alert_notice("Gallery Item Saved", 'success')); 
		                	return redirect()->to(base_url('admin/gallery/create/'.$id));
		            }
		        }
	        }
		}

		// Delete gallery item
		if ($action == 'delete') 
		{ 
			if ($this->contentModel->cancel_gallery(['id' => $id])) 
			{
				$this->creative->delete_file('./' . $gallery['file']);
				$this->creative->delete_file('./' . $gallery['thumbnail']);
	            $this->session->setFlashdata('notice', alert_notice("Item Deleted", 'success')); 
				return redirect()->to(base_url('admin/gallery/'));
			}
		}
		return theme_loader($view_data, null, 'admin'); 
	} 


    /**
     * This methods handles all admin hub management functions 
     * @param  string 	$action 	Determines the action to take on the features
     * @param  string 	$id 	 	The id of the hub to handle
     * @return string           Uses the themeloader() to call and return codeigniter's view() method to render the page
     */
	public function hubs($action = 'list', $id = '', $extra = null)
	{
		// Check and redirect if this module is unavailable for the current  theme
		if (!module_active('_hubs')) return redirect()->to(base_url('admin/dashboard'));

		$userdata  = $this->account_data->fetch(user_id());
		$view_data = array(
			'session' 	 => $this->session,
			'user' 	     => $userdata,
			'page_title' => 'Hub Category',
			'page_name'  => 'hub_type',  
			'action'     => $action,  
			'extra'      => $extra,  
			'set_folder' => 'admin/',
			'acc_data'   => $this->account_data,
			'creative'   => $this->creative,
			'hubs'	     => $this->hubs_m->get_hub(),
			'users'      => $this->usersModel->get() 
		);

		// Create new features
		if (in_array($action, ['create', 'hub_create'])) 
		{
			if ($action === 'hub_create') 
			{
				$hub = $this->hubs_m->get_hub(['id' => $id], 'hubs');
				$view_data['page_name']  = 'hub_create'; 
				$view_data['page_name_'] = 'hub_list'; 
				$view_data['page_title'] = 'Hubs'; 
			}
			else
			{
				$hub = $this->hubs_m->get_hub(['id' => $id]);
				$view_data['page_name'] = 'hub_type_create';
			}
			$view_data['id']         = $id;
			$view_data['hub']        = $hub;
			$view_data['_page_name'] = 'hub_type';

	        if ($this->request->getPost()) 
	        {
		        $save = $this->request->getPost(); 

	        	// Upload image
	        	$banner = ($id) ? $hub['banner'] : ''; 
	        	$require_img = '';
	        	if (!$banner) $require_img = '|is_image[banner]'; 

				if ($action === 'hub_create') 
				{
					$range_l = (!$id) ? range_maker([$save['range_from'],$save['range_to'],false, ';']):'';
	        		$range_f = (!$id) ? '|numeric|required|is_unique_list[hubs.hub_no,'.$range_l.']|less_than_equal_to['.$save['range_to'].']':''; 
	        		$range_t = (!$id) ? '|numeric|required|greater_than_equal_to['.$save['range_from'].']':'';

			        $this->validate([
					    'hub_type'   => ['label' => 'Category', 'rules' => 'trim|required'], 
					    'range_from' => ['label' => 'Range From', 'rules' => 'trim' . $range_f],
					    'range_to'   => ['label' => 'Range To', 'rules' => 'trim' . $range_t] 
					]); 
				}
				else
				{
			        $this->validate([
					    'name'  => ['label' => 'Name', 'rules' => 'trim|required'], 
					    'seats' => ['label' => 'Seats', 'rules' => 'trim|required|numeric'] 
					]);
				}

		        // Validate configuration input data
		        if ($this->form_validation->run($this->request->getPost()) === FALSE)
		        { 
		            $this->session->setFlashdata('notice', $this->form_validation->listErrors('my_error_list')); 
		        } 
		        else 
		        {   
		        	if ($action === 'create' && $this->request->getFile('banner')->isValid())
		        	{
		            	$this->creative->upload('banner', $banner, NULL, NULL, ['width'   => 700, 'height' => 650], 'banner');  
		        	}

		            // Check for upload errors
		            if ($this->creative->upload_errors() === FALSE)
		            {		                
		            	($id) ? $save['id'] = $id : null; 

		            	// Merge banner and post data
		                if (isset($_POST['creative_lib'])) {
		                	$save = array_merge($save, $_POST['creative_lib']);
		                } 

						if ($action === 'hub_create') 
						{	
							$msg = " ";
		                	// Bulk Create Hub 
							if (!$id)
							{
								$msg = 1+($save['range_to']-$save['range_from']);
								foreach (range_maker([$save['range_from'],$save['range_to']]) as $key => $range) 
								{
									$save['hub_no'] = $range;
									$this->hubs_m->save_hub($save, 'hubs');
								}
							}
							// Update Hub
							else
							{
								$this->hubs_m->save_hub($save, 'hubs');
							}

							$id     = true;
							$action = 'hub_list';
							$msg   .= "Hubs Created!";
						}
		                // Create Hub type
						else
						{
					        $id  = $this->hubs_m->save_hub($save);
							$msg = "Hub Detail Saved!";
						}

		                if ($id)
		                	$this->session->setFlashdata('notice', alert_notice($msg, 'success')); 
		                	return redirect()->to(base_url('admin/hubs/' .$action . '/' . $id));
		            }
		        }
	        }
		}
		elseif ($action === 'hub_list') 
		{
			$view_data['hubs'] = $this->hubs_m->get_hub([], 'hubs');
			$view_data['page_name']  = 'hub_list'; 
			$view_data['page_title'] = 'Hubs'; 
		}
		elseif ($action === 'hub_booked') 
		{
			$view_data['hubs'] = $this->bookings_m->get_all();
			$view_data['booking_pg'] = $this->bookings_m->pager;
			$view_data['page_name']  = 'hub_booked'; 
			$view_data['page_title'] = 'Booked Hubs';
			if ($extra === 'cancel' || $extra === 'approve') 
			{
				$status = ($extra === 'cancel') ? 0 : 1;
				$this->bookings_m->book(['id' => $id, 'status' => $status]);
	            $this->session->setFlashdata('notice', alert_notice("Booking ".($status?'Approved':'Canceled'), 'success')); 
				return redirect()->to(base_url('admin/hubs/hub_booked'.($extra==='hubs'?'hub_list':'')));
			}
		}
		// Delete hub item
		elseif ($action == 'delete') 
		{ 
			$hub = $this->hubs_m->get_hub(['id' => $id]);
			if ($this->hubs_m->cancel_hub(['id' => $id, 'table' => $extra])) 
			{	
				if ($action === 'create') 
				{	
					$this->creative->delete_file('./' . $hub['banner']); 
				}
	            $this->session->setFlashdata('notice', alert_notice("Hub Removed", 'success')); 
				return redirect()->to(base_url('admin/hubs/'.($extra==='hubs'?'hub_list':'')));
			}
		}
		return theme_loader($view_data, null, 'admin'); 
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
		if (!module_active('_payments')) return redirect()->to(base_url('admin/dashboard'));

		$userdata  = $this->account_data->fetch(user_id());
		$view_data = array(
			'session'      => $this->session,
			'user' 	       => $userdata,
			'page_title'   => 'Payments',
			'page_name'    => 'payments', 
			'has_table'    => true,
			'set_folder'   => 'admin/',
			'table_method' => 'payments',
			'acc_data'     => $this->account_data 
		);   

		return theme_loader($view_data); 
	} 


    /**
     * This methods handles all analytics functions 
     * @param  string 	$action 	Determines the action to take on the analytic
     * @param  string 	$uid 	 	The id of the a analytic to manage or view
     * @return string           	Uses the themeloader() to call and return codeigniter's view() method to render the page
     */
	public function analytics($action = "list", $id = '')
	{
		// Check and redirect if this module is unavailable for the current  theme
		if (!module_active('_analytics')) return redirect()->to(base_url('admin/dashboard'));

		$userdata  = $this->account_data->fetch(user_id());
		$view_data = array(
			'session'      => $this->session,
			'user' 	       => $userdata,
			'page_title'   => 'Analytics',
			'page_name'    => 'analytics', 
			'has_table'    => true,
			'set_folder'   => 'admin/',
			'table_method' => 'analytics',
			'acc_data'     => $this->account_data 
		);   

		return theme_loader($view_data); 
	} 


    /**
     * This methods handles all admin content management functions 
     * @param  string 	$action 	Determines the action to take on the content
     * @param  string 	$id 	 	The id of the content to handle
     * @return string           Uses the themeloader() to call and return codeigniter's view() method to render the page
     */
	public function content($action = 'list', $id = '')
	{
		// Check and redirect if this module is unavailable for the current  theme
		if (!module_active('_content')) return redirect()->to(base_url('admin/dashboard'));

		$userdata  = $this->account_data->fetch(user_id());

        $parent     = $this->request->getGet('parent'); 
        $set_parent = (!$parent ? 'null' : ''); 
        $query      = array('parent' => $set_parent, 'manage' => TRUE/*, 'page' => $_page*/);

        // Fetch the content
		$content    = $this->contentModel->get_content(['id' => $id], 1); 

		$view_data = array(
			'session' 	 => $this->session,
			'user' 	     => $userdata,
			'page_title' => 'Manage Content',
			'page_name'  => 'content',  
			'errors'     => $this->form_validation,
			'action'     => $action,  
			'set_folder' => 'admin/',
			'acc_data'   => $this->account_data,
			'creative'   => $this->creative,
			'content_md' => $this->contentModel,
			'contents'	 => $this->contentModel->get_content($query),
			'parents'	 => $this->contentModel->get_parent(),
			'users'      => $this->usersModel->get() 
		);

		// Create new content
		if ($action == 'create') 
		{
        	$parent  = $id ? ($content['parent'] ? $content['parent'] : $content['safelink']) : 'non'; 

			$view_data['id']         = $id;
			$view_data['content']    = $content;
			$view_data['page_name']  = 'create_content';
			$view_data['_page_name'] = 'content'; 
			$view_data['children']   = $this->contentModel->get_content(['parent' => $parent]);
            $view_data['parent']     = $content['parent']??null;
			$view_data['children_title'] = $id ? 'Page Content' : 'Pages';

	        if ($this->request->getPost() && !$this->request->getPost('link_parent')) 
	        {
	        	$banner = ($id) ? $content['banner'] : ''; 
	            $this->creative->upload('banner', $banner, NULL, NULL, ['width'   => 3000, 'height' => 2800], 'banner');  

	            // Validate post data
		        $this->validate([
				    'title'    => ['label' => 'Title', 'rules' => 'trim|required'], 
				    'safelink' => ['label' => 'Safelink', 'rules' => 'trim|required|alpha_dash'],
				    'icon.'    => ['label' => 'Icon', 'rules' => 'trim'],
				    'color'    => ['label' => 'Color', 'rules' => 'trim'], 
				    'priority' => ['label' => 'Priority', 'rules' => 'trim|required|numeric|in_list[1,2,3,4,5]'], 
				    'content'  => ['label' => 'Content', 'rules' => 'trim|required'] 
				]);

		        // Check for validation errors
		        if ($this->form_validation->run($this->request->getPost()) === FALSE) 
		        { 
		            $this->session->setFlashdata('notice', $this->form_validation->listErrors('my_error_list')); 
		        } 
		        else 
		        { 	
		        	// Check for image upload errors
		            if ($this->creative->upload_errors() === FALSE)
		            {
		                $save = $this->request->getPost(); 

		                $save['in_footer']    = $save['in_footer'] ?? 0;
		                $save['in_header']    = $save['in_header'] ?? 0;
		                $save['services']     = $save['services'] ?? 0;
		                $save['features']     = $save['features'] ?? 0;
		                $save['contact']      = $save['contact'] ?? 0;
		                $save['subscription'] = $save['subscription'] ?? 0;
		                $save['slider']       = $save['slider'] ?? 0;
		                $save['gallery']      = $save['gallery'] ?? 0;
		                $save['subscription'] = $save['pricing'] ?? 0; 
		                $save['breadcrumb']   = $save['breadcrumb'] ?? 0;
		                
		                // Merge image and post data
		            	($id) ? $save['id'] = $id : null; 		            
		                if (isset($_POST['creative_lib'])) 
		                {
		                	$save = array_merge($save, $_POST['creative_lib']);
		                }
		                $csl = !empty($content['safelink']) ? $content['safelink'] : '';

			            $save['safelink'] = (!$save['safelink'] ? url_title($save['title'], '_', TRUE) : $save['safelink']);
			            $save['safelink'] = (in_array($csl, ['homepage', 'footer', 'welcome', 'about', 'contact']) ? $content['safelink'] : $save['safelink']);

			            // Update the parent
			            if (empty($content['parent']) && $csl)
			            {
			                $this->contentModel->update_parent(['safelink' => $csl, 'parent' => $save['safelink']]);
			            }

			            $save['content'] = encode_html($save['content']);

			            // Save the content
		                if ($id = $this->contentModel->save_content($save))
		                	$this->session->setFlashdata('notice', alert_notice("Content Saved", 'success')); 
	                		return redirect()->to(base_url('admin/content/create/'.$id));
		            }
	            }
	        }
		}
		
		// Delete the content
		if ($action == 'delete') 
		{ 
			if ($this->contentModel->cancel_content(['id' => $id]))
				$this->creative->delete_file('./' . $content['banner']);
	            $this->session->setFlashdata('notice', alert_notice("Content Deleted", 'success')); 
				return redirect()->to(base_url('admin/content/'));
		}
		return theme_loader($view_data, null, 'admin'); 
	} 
}
