<?php namespace App\Controllers;  

class Home extends BaseController
{ 
    /**
     * This is the landing page of the website 
     * @param  string 	$id 	 	The id of the page to view
     * @return string           	Uses the themeloader() to call and return codeigniter's view() method to render the page
     */
	public function index($id = '')
	{
        $id = ($id) ? $id : 'homepage'; 
        $query = array('id' => $id, 'or_safelink' => $id);  

		$content   = $this->contentModel->get_content($query, 1); 
		$home      = $this->contentModel->get_content(array('id' => 'homepage', 'or_safelink' => 'homepage'), 1); 

        if (!error_redirect(empty($content['parent']), '404', true)) return error_redirect(empty($content['parent'])); 
        if (!error_redirect($content, '404', true)) return error_redirect($content);  

		$view_data = array(
			'session' 	 => $this->session,
			'page_title' => $content['title'],
			'page_name'  => 'homepage',
			'_page_name' => $content['safelink'],
			'content'    => $content,
			'home'       => $content,
			'content_md' => $this->contentModel,
			'creative'   => $this->creative,
			'acc_data'   => $this->account_data, 
			'hubs'	     => $this->hubs_m->get_hub(),
			'galleries'	 => $this->contentModel->get_features([], 'gallery'),
        	'sliders'    => $this->contentModel->get_features(['type' => 'slider']),
        	'services'   => $this->contentModel->get_features(['type' => 'service']),
        	'features'   => $this->contentModel->get_features(['type' => 'feature']) 
		); 
 
        $view_data['metatags']  = setOpenGraph([
        	'title' => ($view_data['_page_name'] !== 'homepage' ? my_config('site_name') . ' - ' : '') . $content['title'],
        	'desc' => ($view_data['_page_name'] !== 'homepage' ? my_config('site_description') . ' - ' : '') . $content['content']
        ]); 

		if ($this->account_data->logged_in())
		{
			$view_data['user'] = $this->account_data->fetch(user_id());
		}

		if (my_config('frontend_theme')) 
		{
			$theme_auth = ['theme'=>my_config('frontend_theme')];
		}
		else
		{
			$theme_auth = (in_array('frontend', theme_info(my_config('site_theme'), 'stable'))) ? 'user' : 'default';
		}

		// return view('default/frontend/index', $view_data);
		return theme_loader($view_data, 'frontend/index', $theme_auth);
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
		        	if (my_config('send_activation')) 
			        {  
						$post_data['verified'] = 0;
			        }
		        	$post_data['password'] = $this->enc_lib->passHashEnc($post_data['password']);
		        	$post_data['username'] = $this->account_data->email2username($post_data['email']);  

		        	if ($insert_id = $this->usersModel->save_user($post_data)) 
		        	{	 
		        		\CodeIgniter\Events\Events::trigger('login_redirect', $insert_id, 'user/account');
		        	}
		        }
		    }
		} 
		return theme_loader($view_data, 'frontend/login', null, 'front');
	}

    /**
     * Triggers the logout event and redirects to the homepage
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
	public function logout($redirect = '')
	{
		\CodeIgniter\Events\Events::trigger('logout', $redirect);
		// return redirect()->to(base_url('home'));
		// return $this->account_data->user_logout('home');
	}    
}
