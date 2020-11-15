<?php namespace Config;

use CodeIgniter\Config\Services as CoreServices;

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
}
