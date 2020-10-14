<?php namespace App\Controllers;

class Resources extends BaseController
{
	/**
	 * This methode will generate a file with CORS support
	 * All files and directories should be stored in the [resource] directory of the root directory
	 * When calling a file in a higher level directory, use a [+] in place of a [/] 
	 * Route Info: Both [resource/] and [resources/] are routed here.
	 * @param  	$file 	the name of the file to return
	 * @return 	null
	 */	
	public function index($file = "alimon.css")
	{   
		$resource = "";
		$file = trim(str_ireplace('+', '/', urlencode($file)), '/ ');
		$url  = $this->request->getGet("url_var");
		$url  = trim(($url === "true") ? base_url() : ($url && $url !== "false" ? prep_url($url) : null), '/ ');
		$file_exists = false;

		if (file_exists(PUBLICPATH . "resource/" . $file)) 
		{
			$file_exists = true;
			$resource = trim(file_get_contents(PUBLICPATH . "resource/" . $file));
		} 
		elseif (file_exists(PUBLICPATH . "resources/" . $file)) 
		{
			$file_exists = true;
			$resource = trim(file_get_contents(PUBLICPATH . "resources/" . $file));
		}

		if ($url && $file_exists) 
		{ 
    		$resource = str_replace("var url;", "var url = \"$url/\";", $resource); 
    		$resource = str_replace("var src_url;", "var src_url = \"$url/\";", $resource); 
    	}

		return $this->response
			->setBody($resource)
			->setHeader('Content-Type', get_mime_type($file))
			->setHeader('Access-Control-Allow-Origin', '*')
			->setHeader('Access-Control-Allow-Methods', 'GET')
			->getBody(); 

	}   
}
