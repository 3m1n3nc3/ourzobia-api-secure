<?php namespace App\Controllers; 

class Posts extends BaseController
{    
    /**
     * This is the playground homepage 
     * @param  string 	$pid 	 	The id of the post to view
     * @return string           	Uses the themeloader() to call and return codeigniter's view() method to render the page
     */
	public function index($pid = null, $post_type = 'blog')
	{ 
		// If the user is logged in, allow access
		if (!module_active('posts', my_config('frontend_theme', null, 'default'))) return redirect()->to(base_url('/'));
		if (user_id()) 
		{
			$userdata = $this->account_data->fetch(user_id()); 
			$profile  = $this->account_data->fetch(user_id());  

			if (!account_access($profile['uid'], true)) return account_access($profile['uid']);
		}

		if ($pid === "null") 
		{
			$pid = null;
		}

		$view_data = array(
			'util'       => $this->util,
			'session' 	 => $this->session,
			'creative'   => $this->creative,  
			'acc_data'   => $this->account_data,
			'user' 	     => $userdata??[], 
			'profile' 	 => $profile??[], 
			'page_title' => _lang($post_type),
			'page_name'  => 'posts',
			'post_type'  => $post_type,
			'dir'        => 'frontend',
			'cover_banner' => true,
			'posts' 	 => ($post_type === 'blog') ? $this->postsModel->blog_posts() : $this->postsModel->event_posts(),  
			'pager' 	 => $this->postsModel->pager 
		);  

		// Set the pagination
        if (my_config('pagination') == 'click') 
        {
			$view_data['head_pagination'] = $view_data['pager']->simpleLinks('default', 'default_head');
		}
 		
 		// Prepare MetaTags
		$view_data['metatags'] = setOpenGraph([
			'title' => my_config('site_name') . ' - ' . $view_data['page_title'],
			'url'   => site_url('posts'), 
		]);

 		if ($pid !== null) 
 		{
 			$post = $this->postsModel->get_post(['post_id' => $pid]);

 			if (!empty($post['event_time'])) 
 			{
 				$post_type = 'events';
 			}

 			$view_data['post']       = $post;
 			$view_data['page_title'] = $post['title'] ? $post['title'] : _lang('blog_post_by', [fetch_user('fullname', $post['uid'])]); 

		    $meta  = toArray(json_decode($post['meta']));
 			$image = ($post['type']=='image') ? $post['file'] : ($post['type']=='video' ? $post['thumbnail'] : (!empty($meta['file']) ? $meta['file'] : null));

 			// Prepare MetaTags
 			// Set Opengraph metatags
			$view_data['metatags']  = setOpenGraph([
				'url'   => site_url('posts/post/' . ($post['token']??$post['post_id'])), 
				'title' => my_config('site_name') . $view_data['page_title'],
				'desc'  => $post['description'], 
				'image' => $image ? $this->creative->fetch_image($image) : $image
			]); 
 		}
		
		$view_data['content'] = [
			'title'    => $view_data['page_title'], 
			'intro'    => _lang("latest_{$post_type}_posts"), 
			'safelink' => $post_type ?? 'blog', 
			'banner'   => ' '
		];

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
     * Force file download 
     * @param  string 	$id 	 	The id of the post file to download
     * @param  string 	$type 	 	The type of file to download
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
	public function download($id, $type = 'image')
	{ 
 		$post = $this->postsModel->get_post(['post_id' => $id]);

 		if ($post) 
 		{
 			// Download videos and images
			if (in_array($type, ['video','image'])) 
			{
				$file = $post['file'];
			}
 			// Download meta files
			elseif(!empty($post['meta'])) 
			{
		        $meta  = toArray(json_decode($post['meta']));
		        $file = $meta['file']; 
			}
 		}

 		// Prepare the download
		if (!empty($file)) 
		{ 
			// Download the file
	        $file_instance = new \CodeIgniter\Files\File($file);
	        $fext = $file_instance->getExtension();

		    return $this->response->download(PUBLICPATH . $file, NULL)->setFileName(($post['token']??$post['post_id'].rand()) . '.' . $fext); 
		}

		return redirect()->to(previous_url());
	}  
}