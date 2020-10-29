<?php namespace App\Controllers;

class Src extends BaseController
{
	/**
	 * This method will generate a file resource with CORS headers appended
	 * All files and directories should be stored in the [src] directory of the root path
	 * When calling a file in a higher level directory, use a [+] in place of a [/]  s
	 * @param  	$file 	the name of the file to return
	 * @return 	CodeIgniter\HTTP
	 */	
	public function index($file = "alimon.css")
	{ 
		$resource = "";
		$file = trim(str_ireplace('+', '/', urlencode($file)), '/ ');
		$url  = $this->request->getGet("url_var");
		$url  = trim(($url === "true") ? base_url() : ($url && $url !== "false" ? prep_url($url) : null), '/ ');
		$file_exists = false;

		// Fetch the requested file
		if (file_exists(ROOTPATH . "src/" . $file) && is_file(ROOTPATH . "src/" . $file)) 
		{
			$file_exists = true;
			$resource = trim(file_get_contents(ROOTPATH . "src/" . $file));
		}  

		// Replace all links on the page with the one specified by GET: url_var
		if ($url)
		{
			$regex = '/https?:\/\/(www\.)?[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&\/\/=]*)/m'; 

			preg_match_all($regex, $resource, $matches, PREG_SET_ORDER, 0);
			foreach ($matches as $key => $link) 
			{ 
				if (!empty($link[0])) 
				{
    				$resource = str_replace("url = \"{$link[0]}\";", "url = \"$url/\";", $resource); 
				}
			} 
    		$resource = str_replace("var url;", "var url = \"$url/\";", $resource); 
    		$resource = str_replace("var src_url;", "var src_url = \"$url/\";", $resource); 
		}

		// Return the file after setting the appropriate headers
		if ($file_exists) 
		{
			return $this->response
				->setBody($resource)
				->setHeader('Content-Type', get_mime_type($file))
				->setHeader('Access-Control-Allow-Origin', '*')
				->setHeader('Access-Control-Allow-Methods', 'GET')
				->getBody(); 
    	}
	}   
}
