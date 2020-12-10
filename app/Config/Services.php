<?php namespace Config;

use CodeIgniter\Config\Services as CoreServices;
use \PhpImap\Exceptions\ConnectionException;
use \PhpImap\Exceptions\InvalidParameterException;
use \App\Libraries\Creative_lib; 

/**
 * Services Configuration file.
 *
 * Services are simply other classes/libraries that the system uses
 * to do its job. This is used by CodeIgniter to allow the core of the
 * framework to be swapped out easily without affecting the usage within
 * the rest of your application.
 *
 * This file holds any application-specific services, or service overrides
 * that you might need. An example has been included with the general
 * method format you should use for your service methods. For more examples,
 * see the core Services file at system/Config/Services.php.
 */
class Services extends CoreServices
{

	//    public static function example($getShared = true)
	//    {
	//        if ($getShared)
	//        {
	//            return static::getSharedInstance('example');
	//        }
	//
	//        return new \CodeIgniter\Example();
	//    }

	//--------------------------------------------------------------------

	/**
	 * The mailjet method allows you to send email via mailjet API.
	 *
	 * @param string    $key 
	 * @param string    $secret 
	 * @param boolean   $call 
	 * @param array     $data 
	 * @param boolean   $getShared 
	 *
	 * @return \CodeIgniter\Email\Email|mixed
	 */
	public static function mailjet(string $key, $secret = '', $call = true, $data = ['version' => 'v3.1'], $getShared = true)
	{
		if ($getShared === true)
		{
			return static::getSharedInstance('mailjet', $key, $secret, $call, $data);
		} 
		return new \Mailjet\Client($key, $secret, $call, $data);
	}

	//--------------------------------------------------------------------

	/**
	 * The mailjet_sms method allows you to send SMS via mailjet API.
	 *
	 * @param string    $bearer_token 
	 * @param boolean   $data 
	 * @param array     $debug 
	 * @param boolean   $getShared 
	 *
	 * @return string|boolean
	 */
	public static function mailjet_sms(string $bearer_token, array $data, $debug = false, $getShared = true)
	{
		if ($getShared === true)
		{
			return static::getSharedInstance('mailjet_sms', $bearer_token, $data, $debug);
		} 

        try 
        { 
            $sms = self::mailjet($bearer_token, null, true, [
            	'url' => "api.mailjet.com", 'version' => 'v4', 'call' => true
            ], true);

	        try 
	        { 
	            $send  = $sms->post(\Mailjet\Resources::$SmsSend, ['body' => [
				    'Text' => $data[0],
				    'To'   => $data[1],
				    'From' => $data[2],
				]]);
			}
	        catch (\ErrorException $e) 
	        {
	            return "Error: " . $e->getMessage();
	        }

            if ($debug) 
            { 
                return "<pre>" . json_encode($send->getData(), JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES) . "</pre>";
            }
            else
            {
            	if ($send->success()) 
            	{
            		return true;
            	}
                return $send->getData()['ErrorMessage'];    
            }
        } 
        catch (\GuzzleHttp\Exception\ConnectException $e) 
        {
            return "Error: " . $e->getHandlerContext()['error'];
        }
	}

	//--------------------------------------------------------------------

	/**
	 * The mailjet_subscribe method allows you to add a contact via mailjet API.
	 *
	 * @param string    $key 
	 * @param string    $secret 
	 * @param string    $data 
	 * @param string    $debug 
	 * @param boolean   $getShared 
	 *
	 * @return string|boolean
	 */
	public static function mailjet_subscribe(string $key, $secret = '', array $data = [], $debug = false, $getShared = true)
	{
		if ($getShared === true)
		{
			return static::getSharedInstance('mailjet_subscribe', $key, $secret, $data, $debug);
		} 

        try 
        {  
            $add = self::mailjet($key, $secret, true, ['version' => 'v3'])->post(\Mailjet\Resources::$Contact, ['body' => [
			    'Email' => $data[0],
			    'Name'  => $data[1]??''
			]]);

            if ($debug) 
            { 
                return "<pre>" . json_encode($add->getData(), JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES) . "</pre>";
            }
            else
            {
            	if ($add->success()) 
            	{
            		return true;
            	}
                return $add->getData()['ErrorMessage'];   
            }
        } 
        catch (\GuzzleHttp\Exception\ConnectException $e) 
        {
            return "Error: " . $e->getHandlerContext()['error'];
        }
	}

	//--------------------------------------------------------------------

	/**
	 * The LoadMail method allows you to load email messages via IMAP.
	 *
	 * @param string    $key 
	 * @param string    $secret 
	 * @param string    $data 
	 * @param string    $debug 
	 * @param boolean   $getShared 
	 *
	 * @return string|boolean
	 */
	public static function loadMail(string $urlopen, string $username, string $password, string $path = null, $save_att = false, $getShared = true)
	{
		if ($getShared === true)
		{
			return static::getSharedInstance('loadMail', $urlopen, $username, $password, $path, $save_att);
		} 

    	helper(['site', 'url']);
        $creative = new Creative_lib; 
        $request  = \Config\Services::request(); 

       	$folder = (logged_user('username')) ? url_title(logged_user('username')) . user_id() . '/global/attachments/' : null;
        $upload_path = PUBLICPATH . 'uploads/'.$folder; 
        $uploads_url  = 'uploads/'.$folder; 

	    $att_dir   = null;
	    $mails_ids = [];

        if ($folder && $creative->create_dir($upload_path))
        { 
	        if ($save_att === true) 
	        {
	    		$att_dir = $upload_path;
	        }
        } 
        else
        {
        	$upload_path = $uploads_url = null;
        }

        try 
        {
	        $imap_path = '{' . $urlopen . '/imap/ssl/novalidate-cert}INBOX';
	        $mailbox   = new \PhpImap\Mailbox($imap_path, $username, $password, $att_dir);

	        $mailbox->setConnectionArgs(
	            CL_EXPUNGE  
	            // | OP_SECURE  
	        );
			$mailbox->sortMails(SORTARRIVAL);

	        $c = [];
	        $error     = '';

			if ($path) 
			{
				$mailbox->switchMailbox($path); 
			}

			if ($request->getGet('q')) 
			{
        		$mail_ids = $mailbox->searchMailboxMergeResultsDisableServerEncoding( 
        			(String)'SUBJECT "' . $request->getGet('q') . '"',
        			(String)'BODY "' . $request->getGet('q') . '"',
        			(String)'FROM "' . $request->getGet('q') . '"',
        			(String)'KEYWORD "' . $request->getGet('q') . '"',
        			(String)'TEXT "' . $request->getGet('q') . '"'
        		);
			}
			else
			{
	        	$mails_ids = $mailbox->searchMailbox('ALL');
			}
			$mailbox->setPathDelimiter('/');
        } 
        catch(ConnectionException | InvalidParameterException | \ErrorException $ex) 
        {
            $error = "IMAP Error: " . $ex->getMessage(); 
        }

        return [
            'mailbox'     => $mailbox,
            'mails_ids'   => $mails_ids,
            'upload_path' => $upload_path,
            'uploads_url' => $uploads_url,
            'error'       => $error
        ];
    }
} 