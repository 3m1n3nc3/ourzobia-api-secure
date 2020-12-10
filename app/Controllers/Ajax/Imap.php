<?php namespace App\Controllers\Ajax;

use App\Controllers\BaseController;  
use \PhpImap\Exceptions\ConnectionException;
use \PhpImap\Exceptions\InvalidParameterException; 

class Imap extends BaseController
{ 

	/**
	 * Configuration settings for the site, 
	 * if istantated from an ajax request
	 * @return json response to send to the client
	 */
	public function index()
	{ 
		$mail_path = base64_url($path, 'decode');
	}

	public function action($path = '')
	{  
		// Check if user is logged in and the method is accessed via ajax
		if ($this->util::loggedInIsAJAX() !== true)
			return $this->util::loggedInIsAJAX();
		
	    $data['success'] = false;
	    $data['status']  = 'error';
	    $data['message'] = _lang('an_error_occurred'); 

	    if ($path) 
	    {
			$post_data = $this->request->getPost();
			$mail_path = base64_url($path, 'decode');

	    	$load_mail = \Config\Services::loadMail(
	    		my_config('cpanel_domain') . ':993', 
	    		fetch_user('enterprise_mail', user_id()), 
	    		$this->session->get('password_token'),
	    		$mail_path
	    	);

    		$mailbox = $load_mail['mailbox'];
			$mailbox->setAttachmentsIgnore(true); 

			try
			{
			    $data['success'] = true;
			    $data['status']  = 'success';
			    $data['message'] = false;
				if ($post_data['action'] === 'delete') 
				{
					foreach ($post_data['ids'] as $key => $mid) 
					{
						$mailbox->deleteMail($mid);
					} 
					
					$count = count($post_data['ids']);
				    $data['message'] = $count > 1 ? "$count Messages Deleted!" : "Message Deleted!";  
				}
				elseif ($post_data['action'] === 'flag') 
				{
					$mailbox->markMailsAsImportant($post_data['ids']);
				}
				elseif ($post_data['action'] === 'unflag') 
				{
					$mailbox->clearFlag($post_data['ids'], '\Flagged');
				}
			}
			catch(ConnectionException | InvalidParameterException | \UnexpectedValueException | \ErrorException $ex) 
	        {  
	            $data['message'] = "IMAP Error: " . $ex->getMessage(); 
	        }  
	    }

		return $this->response->setJSON($data);
	}

	public function loader($referrer = 'inbox', $path = '')
	{  
		// Check if user is logged in and the method is accessed via ajax
		if ($this->util::loggedInIsAJAX() !== true)
			return $this->util::loggedInIsAJAX();
		
	    $data['success'] = false;
	    $data['status']  = 'error';
	    $data['message'] = _lang('an_error_occurred'); 

	    if ($path) 
	    {
			$post_data  = $this->request->getPost();
			$paging = $this->request->getGet('page') ?? 1;
			$mail_path  = base64_url($path, 'decode');

	    	$load_mail = \Config\Services::loadMail(
	    		my_config('cpanel_domain') . ':993', 
	    		fetch_user('enterprise_mail', user_id()), 
	    		$this->session->get('password_token'),
	    		$mail_path
	    	);
			$mail_folder = folder_name($mail_path, true);
	    	$mailbox     = $load_mail['mailbox'];
	    	$mails_ids   = $load_mail['mails_ids'];
	    	$upload_path = $load_mail['upload_path'];
	    	$data['message'] = $error = $load_mail['error'];

			$folders  = [];
			try
			{
				$mailbox->setPathDelimiter('/');
				$mailbox->setAttachmentsIgnore(true);
				$folders = $mailbox->getMailboxes('*'); 
			}
			catch(\ErrorException $ex)
			{
	    		$data['message'] = $error = $ex->getMessage(); 
			}

			$count_mail = count($mails_ids);
			if ($mails_ids) 
			{
	            $limit = my_config('perpage', null, 5);
	            $page  = min($paging, ceil( $count_mail/ $limit )); 
	            $offset = ($page - 1) * $limit;
	            if( $offset < 0 ) $offset = 0;

				$view_data = array( 
					'page_title'  => ucwords("Mailbox $mail_folder"),
					'page_name'   => 'mail',   
					'set_folder'  => 'user/', 
					'widget'      => 'mailbox', 
					'mail_error'  => $load_mail['error'],
					'folders'     => $folders,
					'mailbox'     => $mailbox,
					'curr_folder' => $mail_folder,
					'mails_ids'   => $mails_ids, 
					'pagination'  => $paging, 
					'count_mail'  => $count_mail, 
					'upload_path' => $load_mail['upload_path']??'',
					'uploads_url' => $load_mail['uploads_url']??'', 
					// pagination data 
	                'offset'    => $offset,
	                'limit'     => $limit
				);  

			    $data['success'] = true;
			    $data['status']  = 'success';
			    $data['message'] = $error; 
			    $data['page_url']   = site_url("mail/hub/$referrer/$path/?hash=" . csrf_hash() . ($paging > 1 ? '&page='.$paging : '')); 
			    $data['page_title'] = $view_data['page_title']; 
				$data['html']       = load_widget("mail/mailbox_table", $view_data);
			    $data['pagination'] = ((($paging*$limit)-$limit) . '-' . ($count_mail >= $paging*$limit ? $paging*$limit : $count_mail) . '/' . $count_mail) .
	                service('pager')->makeLinks($paging, $limit, $count_mail, 'custom_mail');
	        }
		}

		return $this->response->setJSON($data);
	}
}