<?php namespace App\Controllers\Ajax;

use App\Controllers\BaseController; 

require_once VENDORPATH . 'jodit-connector/loader.php';  

class Jodit extends BaseController
{ 

	/**
	 * Configuration settings for the site, 
	 * if istantated from an ajax request
	 * @return json response to send to the client
	 */
	public function index()
	{ 
		if (!$this->session->has('JoditUserRole')) 
		{
			$this->session->set('JoditUserRole', logged_user('admin'));
		}
		$privacy = $this->request->getGet('privacy');
        $folder  = (user_id() && $privacy === 'user') ? url_title(logged_user('username')) . user_id() . '/global/' : 'content/global/'; 
        $upload_path = PUBLICPATH . 'uploads/' . $folder; 

		$config = [ 
		    'quality' => 90,
		    'defaultPermission' => 0777, 
		    'root' => rtrim($upload_path, '/'),
    		'baseurl' => base_url('uploads/' . $folder) . '/',
		    'extensions' => ['jpg', 'png', 'gif', 'jpeg', 'mp4'],
		    'maxFileSize' => '5mb'
		]; 

		$config = array_merge(JODIT_CONFIG, $config);

        if ($this->creative->create_dir($upload_path))
        {   
			$fileBrowser = new \JoditRestApplication($config);

			try {
				// $fileBrowser->checkAuthentication();
				$fileBrowser->execute();
			} catch(\ErrorException $e) {
				$fileBrowser->exceptionHandler($e);
			}
        } 
	}
}
