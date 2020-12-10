<?php namespace App\Controllers;

use \App\Libraries\Util;
use \PhpImap\Mailbox;
use \PhpImap\Exceptions\ConnectionException;
use \PhpImap\Exceptions\InvalidParameterException;
use \PhpImap\Exceptions\UnexpectedValueException;
use \PhpImap\Exceptions\InvalidArgumentException;

class Mail extends BaseController
{
	public function index($page = 'inbox', $action = null)
	{
		// Check and redirect if this module is unavailable for the current  theme
		if (!module_active('mail')) return redirect()->to(base_url('user/account'));  

		$userdata   = $this->account_data->fetch(user_id());
		$pagination = $this->request->getGet('page');

		// Force login
		if (!$this->session->has('password_token')) 
		{
			return theme_loader([
				'page_title' => 'Request Mailbox Access', 
				'screen'     => 'login',
				'help_action'=> 'access mailbox!',
				'set_token'  => 'password_token',
				'redirect'   => urlencode("mail")
			], 'frontend/basic', 'front'); 
		}

    	$load_mail = \Config\Services::loadMail(
    		my_config('cpanel_domain') . ':993', 
    		fetch_user('enterprise_mail', user_id()), 
    		$this->session->get('password_token')
    	);
		$mail_folder = folder_name($page, true);
    	$mailbox     = $load_mail['mailbox'];
    	$mails_ids   = $load_mail['mails_ids'];
    	$upload_path = $load_mail['upload_path'];

		$folders   = []; 
		try
		{
			$mailbox->setPathDelimiter('/');
			$mailbox->setAttachmentsIgnore(true);
			$folders   = $mailbox->getMailboxes('*'); 
		}
		catch(\ErrorException $e)
		{

		}

		$view_data = array(
			'session' 	  => $this->session,
			'user' 	      => $userdata,  
			'page_title'  => ucwords("Mailbox $mail_folder"),
			'page_name'   => 'mail',   
			'set_folder'  => 'user/', 
			'widget'      => 'mailbox', 
			'mail_error'  => $load_mail['error'],
			'folders'     => $folders,
			'mailbox'     => $mailbox,
			'curr_folder' => $mail_folder,
			'mails_ids'   => $mails_ids,
			'referrer'    => $page,  
			'pagination'  => $pagination ?? 1, 
			'count_mail'  => count($mails_ids), 
			'upload_path' => $load_mail['upload_path']??'',
			'uploads_url' => $load_mail['uploads_url']??'',
			'acc_data'    => $this->account_data,
			'util'        => $this->util,
			'creative'    => $this->creative
		);  

		return theme_loader($view_data);  
	}


	public function hub($page = 'inbox', $path = null, $id = null)
	{  
		helper(['number']);
		// Check and redirect if this module is unavailable for the current  theme
		if (!module_active('mail')) return redirect()->to(base_url('user/account'));  

		$userdata    = $this->account_data->fetch(user_id());

		$pagination  = $this->request->getGet('page');
		$mail_path   = (in_array($page, ['folder', 'read']) && base64_url($path, 'decode')) ? base64_url($path, 'decode') : null; 
		// Force login
		if (!$this->session->has('password_token')) 
		{
			return theme_loader([
				'page_title' => 'Request Mailbox Access', 
				'screen'     => 'login',
				'help_action'=> 'access mailbox!',
				'set_token'  => 'password_token',
				'redirect'   => urlencode("mail/hub/$page" . ($path ? '/' . $path : '') . ($id ? '/' . $id : ''))
			], 'frontend/basic', 'front'); 
		}

		$mail_folder = folder_name($mail_path ?? $page, true);
    	$load_mail   = \Config\Services::loadMail(
    		my_config('cpanel_domain') . ':993', 
    		fetch_user('enterprise_mail', user_id()), 
    		$this->session->get('password_token'),
    		$mail_path
    	);
    	$mailbox   = $load_mail['mailbox'];
    	$mails_ids = $load_mail['mails_ids']; 
    	$error     = $load_mail['error']; 

		$all_mail  = $mailbox;
		$folders   = []; 
		try
		{
			if ($mail_folder !== 'inbox') 
			{
	    		$all_mail = \Config\Services::loadMail(
		    		my_config('cpanel_domain') . ':993', 
		    		fetch_user('enterprise_mail', user_id()), 
		    		$this->session->get('password_token'),
	    			null, 
	    			false, 
	    			false
	    		)['mailbox'];
				$all_mail->setAttachmentsIgnore(true); 
			} 
			$folders   = $all_mail->getMailboxes('*'); 
		}
		catch(\ErrorException | InvalidArgumentException $e)
		{
    		$error = $e->getMessage(); 
		}

		$view_data = array(
			'session' 	  => $this->session,
			'user' 	      => $userdata,  
			'page_title'  => ucwords("Mailbox $mail_folder"),
			'page_name'   => 'mail',   
			'set_folder'  => 'user/', 
			'widget'      => 'mailbox', 
			'mail_error'  => $load_mail['error'],
			'folders'     => $folders,
			'mailbox'     => $mailbox,
			'curr_folder' => $mail_folder,
			'mails_ids'   => $mails_ids,  
			'referrer'    => $page, 
			'pagination'  => $pagination ?? 1, 
			'count_mail'  => count($mails_ids), 
			'upload_path' => $load_mail['upload_path']??'',
			'uploads_url' => $load_mail['uploads_url']??'',
			'acc_data'    => $this->account_data,
			'util'        => $this->util,
			'creative'    => $this->creative
		);   

		if ($page === 'read') 
		{ 
			$view_data['widget']  = 'reader';
			$view_data['mail_id'] = $id;
            $view_data['email']   = $mailbox->getMail($id, true);
            $view_data['head']    = $mailbox->getMailHeader($id);
            $view_data['mail_info'] = $mailbox->getMailsInfo([$id])[0] ?? null;
		}
		else
		{ 
			$mailbox->setAttachmentsIgnore(true);  
		}

		if ($error) 
		{
			$this->session->setFlashdata('notice', alert_notice($error, "error", false, false));
		}

 		// Download file
		if ($this->request->getPost('download')) 
		{ 
			// Download the file 
		    return $this->response->download(PUBLICPATH . $this->request->getPost('download'), NULL); 
		}

		return theme_loader($view_data);  
	}


	public function compose($path = null, $id = null)
	{   
		// Check and redirect if this module is unavailable for the current  theme
		if (!module_active('mail')) return redirect()->to(base_url('user/account'));  

		$userdata  = $this->account_data->fetch(user_id());
		$post_data = $this->request->getPost();
		$mail_path = ($path && base64_url($path, 'decode')) ? base64_url($path, 'decode') : null; 

 		
		$folders     = $mailbox = [];
		$mail_folder = $error   = '';

		// Force login
		if (!$this->session->has('password_token')) 
		{
			return theme_loader([
				'page_title' => 'Request Mailbox Access', 
				'screen'     => 'login',
				'help_action'=> 'access mailbox!',
				'set_token'  => 'password_token',
				'redirect'   => urlencode('mail/compose' . ($path ? '/' . $path : '') . ($id ? '/' . $id : ''))
			], 'frontend/basic', 'front'); 
		}
  
    	$load_mail   = \Config\Services::loadMail(
    		my_config('cpanel_domain') . ':993', 
    		fetch_user('enterprise_mail', user_id()), 
    		$this->session->get('password_token'),
    		$mail_path
    	);
    	$mailbox = $load_mail['mailbox']; 
    	$error   = $load_mail['error']; 

		try
		{ 
			$all_mail = $mailbox;  
			if ($mail_folder !== 'inbox') 
			{
	    		$all_mail = \Config\Services::loadMail(
		    		my_config('cpanel_domain') . ':993', 
		    		fetch_user('enterprise_mail', user_id()), 
		    		$this->session->get('password_token'),
	    			null, 
	    			false, 
	    			false
	    		)['mailbox'];
				$all_mail->setAttachmentsIgnore(true); 
			} 
			$folders = $all_mail->getMailboxes('*'); 

			if (($post_data['action']??null) === 'draft') 
			{
				$draft = mail_draft($post_data['recipients'], $post_data['subject'], $post_data['message']); 
				$mailbox->setPathDelimiter('.');
				if ($mailbox->appendMessageToMailbox($draft, "Drafts")) 
				{
					$this->session->setFlashdata('notice', alert_notice('Draft Saved!', "success", false, false));
				}
			}
			elseif (($post_data['action']??null) === 'send') 
			{
	            // Send the mail now 
	            $sendMail = Util::sendMail([
	                'success'  => 'Mail Sent',
	                'subject'  => $post_data['subject'],
	                'message'  => $post_data['message'], 
	                'receiver' => [
	                	'email' => $post_data['recipients'], 
	                	'fullname' => $post_data['recipients']
	                ],
	                'sender'   => [
	                	'email' => fetch_user('enterprise_mail', user_id()), 
	                	'fullname' => fetch_user('fullname', user_id())
	                ],
	            ], [
	            	'username' => fetch_user('enterprise_mail', user_id()),
	            	'password' => $this->session->get('password_token'),
	            	'hostname' => my_config('cpanel_domain'),
	            	'hostport' => '587'
	            ]);
	            if ($sendMail['success'] === true) 
	            {
					// $sent = mail_draft($post_data['recipients'], $post_data['subject'], $post_data['message']); 
					// $mailbox->setPathDelimiter('.');
					// $mailbox->appendMessageToMailbox($sent, "Sent");
	            }
	            $this->session->setFlashdata('notice', alert_notice($sendMail['message'], $sendMail['status'], false, false));
			}

		}
		catch(\ErrorException | \UnexpectedValueException $e)
		{
    		$error = $e->getMessage(); 
		} 

		$view_data = array(
			'session' 	  => $this->session,
			'user' 	      => $userdata,  
			'page_title'  => ucwords("Mailbox Compose"),
			'page_name'   => 'mail',   
			'set_folder'  => 'user/', 
			'widget'      => 'composer',  
			'folders'     => $folders,
			'mailbox'     => $mailbox,
			'mail_id'     => $id, 
			'acc_data'    => $this->account_data,
			'util'        => $this->util,
			'creative'    => $this->creative,
			'recipients'  =>$this->request->getPost('recipients') ?? ''
		);   

		if ($id)
		{   
            $view_data['email'] = $mailbox->getMail($id, true);
            $view_data['head']  = $mailbox->getMailHeader($id);
            $view_data['mail_info'] = $mailbox->getMailsInfo([$id])[0] ?? null;
		} 
		else
		{ 
			$mailbox->setAttachmentsIgnore(true);  
		}

		if ($error) 
		{
			$this->session->setFlashdata('notice', alert_notice($error, "error", false, false));
		}

		return theme_loader($view_data);  
	}
}
