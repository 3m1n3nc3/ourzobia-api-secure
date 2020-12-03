<?php namespace App\Libraries; 

use App\Libraries\Account_Data;

class Creative_lib {

    function __construct() {
        helper('date');
        $this->request = \Config\Services::request();
    }

    public function resize_image($src = '', $_config = '')
	{	 
		$image_library  = !empty($_config['image_library']) ? $_config['image_library'] : 'gd';
		$maintain_ratio = !empty($_config['maintain_ratio']) ? $_config['maintain_ratio'] : TRUE;
        $width          = !empty($_config['width']) ? $_config['width'] : 450;
        $height         = !empty($_config['height']) ? $_config['height'] : 450; 
		$crop   	    = !empty($_config['crop']) ? $_config['crop'] : NULL; 

        $_image = \Config\Services::image($image_library);

        try 
        { 
            $_image->withFile($src);
            if (!empty($crop)) 
            {
                $_image->fit($crop[0], $crop[1]);
            }
            else
            {
                $_image->resize($width, $height, $maintain_ratio); 
            }
 
            $_image->save($src);

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

            if (!file_exists(PUBLICPATH . $image))
            {
                $image = my_config('default_banner'); 
            }

            if (!file_exists($image))
            {
                $image = 'resources/img/default_logo.png'; 
            }

            if (env('installation.status', 'false') === false) 
            {
                return create_url($image);
            }
			return base_url($image);
		}
	}

    
    /**
     * This method will fetch and save an image or media file
     * from a remote location, most probably a url
     * @param  string  $file_path the absolute url to the file to save
     * @param  boolean $save      true or false whether to save the file or just return it's base name
     * @return string 
     */
    public function saveRemoteFile(string $file_path, $save = false)
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
            $upload_path = PUBLICPATH . 'uploads/'.$folder; 

            if ($this->create_dir($upload_path))
            {
                $rand_name = "meta_" . $file->getRandomName();
                $file_name = $upload_path . $rand_name;
                file_put_contents($file_name, $response->getBody());
                $this->resize_image($file_name, ['width'=>500, 'height'=>500]);
            } 
            return 'uploads/'.$folder . $rand_name;
        }
        else
        {
            return $file->getBasename();
        }
    }


    /**
     * Uploads a media file and thumbnail if supplied by request
     * @return array
     */
    public function uploadWithThumbnail()
    {
        $item_file = $thumbnail_file = $error = NULL;

        // Check if this upload has a thumbnail
        $thumbnail = $this->request->getPost('thumbnail');

        // Get the item thumbnail if available
        if ($thumbnail) 
        {
            $thumb      = explode(';', $thumbnail);
            $thumbnail_ = isset($thumb[1]) ? $thumb[1] : null; 
            $file_ext   = isset($thumb[0]) ? str_ireplace('data:image/', '', $thumb[0]) : 'png'; 

            if (isset($thumbnail_))
            {
                list($type, $thumbnail) = explode(';', $thumbnail);
                list(, $thumbnail) = explode(',', $thumbnail);
                $t_image = base64_decode($thumbnail);
                $thumbnail_image = 'thumb_'.mt_rand().'_'.mt_rand().'_p.' . $file_ext;
                $upload_path = PUBLICPATH . 'uploads/thumbs/'; 

                // Save the new image to the upload directory              
                if ($t_image)
                {
                    if ( ! $this->create_dir($upload_path))
                    {
                        $error = 'The thumbnail destination folder does not appear to be writable.'; 
                    }
                    else
                    {
                        // $this->delete_file('./' . $data[$table_index]);

                        if ( ! file_put_contents($upload_path . $thumbnail_image, $t_image) )
                        {
                            $error = 'The file could not be written to disk.'; 
                        }
                        else {
                            $thumbnail_file = 'uploads/thumbs/' . $thumbnail_image;
                        }
                    }
                }
            }
        }

        // Get the item image or video file
        if (empty($error) && $this->request->getFile('file')) 
        {
            $new_name = 'item_'.rand().'_'.rand();

            $item_files = $this->upload('file', NULL, $new_name,  NULL, [1000,1000]); 
            if ($this->upload_errors('file') !== FALSE)
            {
                $error = $this->upload_errors('file', '','');
            }
            else
            {
                $item_file = $item_files['new_path'];
            }
        }

        return array(
            "file"      => $item_file,
            "thumbnail" => $thumbnail_file,
            "error"     => $error
        );
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
