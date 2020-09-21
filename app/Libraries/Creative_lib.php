<?php namespace App\Libraries; 

use App\Libraries\Account_Data;

class Creative_lib {

    function __construct() {
        helper('date');
        $this->request = \Config\Services::request();
    }

    public function resize_image($src = '', $_config = '')
	{	 
		$image_library  = isset($_config['image_library']) ? $_config['image_library'] : 'gd';
		$maintain_ratio = isset($_config['maintain_ratio']) ? $_config['maintain_ratio'] : TRUE;
		$width 	        = isset($_config['width']) ? $_config['width'] : 450;
		$height         = isset($_config['height'])? $_config['height'] : 450; 

        $_image = \Config\Services::image($image_library);

        try { 
            $_image
            ->withFile($src)
            ->resize($width, $height, $maintain_ratio)
            ->save($src);

            chmod($src, 0777);
            return TRUE;
        }
        catch (CodeIgniter\Images\ImageException $e)
        {
            return $e->getMessage();
        } 
	} 

	public function create_dir($path = '', $error = null) 
	{ 
		if (file_exists($path)) {
			
			if(is_writable($path)) 
			{	
				return TRUE;
			} 
			else 
			{
				return chmod($path, 0777) OR FALSE;
			}  
		}
		elseif (!$error) 
		{	
            try
            {
                return mkdir($path, 0777, TRUE);  
            }
            catch (\ErrorException $e)
            {
                 
            }
		}
		
		return FALSE;
	}

	public function delete_file($path = '')
	{ 
		if (file_exists($path) && is_file($path)) 
        {
			if (!is_writable($path)) chmod($path, 0777);
			return unlink($path);
		}
		return FALSE;
	}

	public function fetch_image($src = '', $default = 1)
	{	  
		if ($src && file_exists(PUBLICPATH . $src)) 
        {
			return base_url($src);
		} 
        else 
        {
            $image = 'resources/img/default_'.$default.'.png';

            if (!file_exists(PUBLICPATH . 'resources/img/default_'.$default.'.png')) 
            {
                $image = my_config('default_banner'); 
            }

            if (env('installation.status', 'false') === false) 
            {
                return create_url($image);
            }
			return base_url($image);
		}
	}
   
    public function saveRemoteFile($file_path, $save = false)
    {         
        // Create an instance  of the file
        $file = new \CodeIgniter\Files\File($file_path);
        $account_data = new Account_Data;
        
        // Save the file
        if ($save === true) 
        {
            // Create a CURL Request for the file
            $client   = \Config\Services::curlrequest();
            $userdata = $account_data->fetch(user_id()); 
            $folder   = (!empty($userdata['username'])) ? $userdata['username'] . user_id() . '/' : 'content/';
            $options  = [
                'headers' => [
                    'User-Agent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.89 Safari/537.36',
                    'referrer' => site_url()
            ]];
            $response = $client->request('GET', $file_path, $options);

            file_put_contents(PUBLICPATH . 'uploads/'.$folder . $file->getBasename(), $response->getBody());
            $this->resize_image(PUBLICPATH . 'uploads/'.$folder . $file->getBasename(), ['width'=>500, 'height'=>500]);
            return 'uploads/'.$folder . $file->getBasename();
        }
        else
        {
            return $file->getBasename();
        }
    }
   
    public function upload($index, $previous = NULL, $new_name = NULL, $folder = NULL, $resize = array(), $set_post = FALSE)
    { 
        $file_instance = $this->request->getFile($index);

        if (isset($_FILES[$index]) && $_FILES[$index]['name']) 
        { 
            $upload_data = array();
            $upload_errors = FALSE; 

            // Set the new name for the upload
            if (!$new_name) 
            {
                $new_name = 'img_'.rand().'_'.rand();
            }

            $new_name   = $new_name.'.' . $file_instance->getExtension();
            $new_folder = ($folder) ? $folder . '/' : 'content/';
            $directory  = 'uploads/' . $new_folder;

            // Set the parameters for this upload
            $upload_path      = PUBLICPATH . $directory; 

            // Create a directory for this upload, if it doesn't exist
            if ( ! $this->create_dir($upload_path) ) 
            { 
                $upload_errors = 'Unable to write this file'; 
            } 
            else 
            {
                // Delete any previous file if set
                $this->delete_file(PUBLICPATH . $previous);
            }

            // Do the upload
            if ( ! $file_instance->isValid() )
            {
                $upload_errors = $file_instance->getErrorString(); 
            }
            else
            {
                // Upload the file
                if ($file_instance->isValid() && ! $file_instance->hasMoved())
                {
                    try { 
                        $file_instance->move($upload_path, $new_name);
                    }
                    catch (\CodeIgniter\HTTP\Exceptions\HTTPException $e)
                    {
                        $upload_errors =  $e->getMessage();
                    } 
                }
                $upload_data             = []; 
                $upload_data['new_path'] = $directory . $new_name;  
                $upload_data['errors']   = $upload_errors;  
                chmod($upload_path . $new_name, 0777);

                // Set post data for this upload (important if you do not 
                // intend to retrieve upload file directory from upload_data)
                if ($set_post) 
                {
                    if ($set_post === TRUE) 
                    {
                        $_POST[$index] = $upload_data['new_path'];
                    }
                    else
                    {
                        if (is_array($set_post))
                        { 
                            foreach ($set_post as $key => $value) 
                            { 
                                $param = array($value => $upload_data['new_path']);
                                $_NEWPOST[$key] = $param;
                            }
                            if (isset($_POST)) 
                            {
                                $_POST = array_merge($_POST, $_NEWPOST);
                            }
                            else
                            {
                                $_POST = $_NEWPOST;
                            }
                        }
                        else
                        {
                            $_NEWPOST[$set_post] = $upload_data['new_path'];
                            $_POST[$set_post]    = $upload_data['new_path'];
                        } 
                        $_POST['creative_lib'] = $_NEWPOST;
                    }
                }

                 // Array ( [value] => Array ( [site_name] => Hayatt Regency Suited ) [site_logo] => uploads/sites/site_logo.png )
                // Resize this image file

                if ($resize && preg_match('/\.(jpg|png|jpeg)$/', $upload_path.$new_name)) 
                {
                    // $resize['width'], $resize['height']
                    $this->resize_image($upload_path.$new_name, $resize); 
                }
            }
            
            $this->upload_errors = array();
            if ($upload_errors) 
            {
                $this->upload_errors[$index] = $upload_errors; 
            }

            // Return the upload data array
            if (isset($upload_data)) 
            {
                return $upload_data;    
            }

            return FALSE;
        }
    }
    

    public function upload_errors($index = NULL, $prefix = '<p>', $suffix = '</p>')
    {
        if (isset($this->upload_errors[$index])) 
        {
            return $prefix . $this->upload_errors[$index] . $suffix;
        } 

        return FALSE;
    }  
}
