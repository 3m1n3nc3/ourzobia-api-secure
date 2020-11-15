<?php namespace App\Controllers; 

use App\Libraries\Notifications;
use App\ThirdParty\Spam_filter\SpamFilter; 

class Connect extends BaseController 
{
	public function index()
	{
		return $this->response->setJSON(['version' => 'v1.0.0']);  
	}  

    /**
     * Handles ajax image uploads
     * @param  string 	$endpoint_id	Specifies the id of the content receiving the image record
     * @param  string 	$endpoint		Specifies the type of content receiving the image record
     * @return null     Does not return anything but echoes a JSON Object with a response
     */
	public function upload_image($endpoint_id = '', $endpoint = 0)
	{ 	 
        $ntfn = new Notifications;
        if ($this->util::loggedInIsAJAX() !== true)
            return $this->util::loggedInIsAJAX();
 
        $folder = 'content/';  
		if ($endpoint === 'avatar' || $endpoint === 'cover') 
		{  
			$user_id = $endpoint_id ? $endpoint_id : user_id();

            $data    = model('App\Models\UsersModel', false)->get_user($user_id); 
            $folder  = $data['username'] . $data['uid'] . '/'; 
		}
		elseif ($endpoint === 'pop') 
		{  
            $data    = $this->pairingModel->getselect($endpoint_id);  
		} 
		elseif ($endpoint === 'content') 
		{  
            $data    = $this->contentModel->get_content(['id' => $endpoint_id], true);  
		} 

		$table_index = ($endpoint == 'content') ? 'banner' : $endpoint; 

        $upload_type = $this->request->getPost('set_type'); 
		$extra_data  = $this->request->getPost('data'); 

		// Set the upload directory
        $upload_path = PUBLICPATH . 'uploads/' . $folder; 

		if (isset($data)) 
        { 
			// Check if this upload is ajax
			$file = $this->request->getPost('ajax_image');
			if ($file) 
			{
			  	$ajax_image_ = explode(';', $file);
			  	$ajax_image_ = isset($ajax_image_[1]) ? $ajax_image_[1] : null; 
			}

			if (isset($ajax_image_))
			{ 
				list($type, $file) = explode(';', $file);
				list(, $file) = explode(',', $file);
				$image = base64_decode($file);
				$new_image = mt_rand().'_'.mt_rand().'_'.mt_rand().'_p.png';

			  	// Save the new image to the upload directory              
			  	if ($image)
			  	{
	                if ( ! $this->creative->create_dir($upload_path))
	                {   $data['upload_path'] = $upload_path;
	                    $data['error'] = alert_notice('The upload destination folder is not writable.', 'danger', FALSE, 'FLAT'); 
	                }
	                else
	                {
	                    $this->creative->delete_file('./' . $data[$table_index]);

		                if ( ! file_put_contents($upload_path . $new_image, $image) )
		                {
		                    $data['error'] = alert_notice('The file could not be written to disk.', 'danger'); 
		                }
		                else
		                {
                            if (!empty($extra_data['width']) || !empty($extra_data['height']) || !empty($extra_data['crop'])) 
                            {   
                                $width  = $extra_data['width'] ?? NULL;
                                $height = $extra_data['height'] ?? NULL;
                                $crop   = $extra_data['crop'] ?? NULL; 

                                $this->creative->resize_image($upload_path . $new_image, [
                                    'width' => $width, 'height' => $height, 'crop' => $crop
                                ]);
                            } 

		                    $data_img = 'uploads/' . $folder . $new_image;

							if ($endpoint === 'avatar' || $endpoint === 'cover') 
							{
								$this->usersModel->save_user(['uid' => $data['uid'], $table_index => $data_img]); 
							} 
							elseif ($endpoint === 'content') 
							{ 	
								$this->contentModel->save_content(['id' => $data['id'], $table_index => $data_img]); 
							} 

		                    chmod($upload_path.'/'.$new_image, 0777);
		                    $data['success'] = alert_notice('Your upload was completed successfully.', 'success', FALSE, 'FLAT');
		                }
	                }
	            } 
			} 
			elseif (empty($ajax_image_)) 
			{
	            $data['error'] = alert_notice('We were unable to process this upload, maybe you did not select a file.', 'danger', FALSE, 'FLAT'); 
			}
		} 
		else 
		{
            $data['error'] = alert_notice('Unable to find parent content, please contact your server admin', 'danger', FALSE, 'FLAT'); 
		}

        return $this->response->setJSON($data);   
	} 


    /**
     * Fetches notifications for the currently logged in user 
     * @return NULL     Echoes a json string containing the notifications
     */
    public function fetch_notifications($segment = 'admin', $data_segment = 'admin')
    { 
        $ntfn = new Notifications;

        try 
        {
            $param      = ['recipient_id' => user_id(), 'type' => 'all'];
            $notif_list = $ntfn->getNotifications($param); 
            $data['notifications'] = $notif_list;  
            $data['segment']       = $data_segment;
            
            $response['success'] = true;
            $response['status']  = 'success';
            if ($segment == 'admin') 
            {
                $response['html']= load_widget('notifications', $data);
            }
            else
            {
                $response['html']= load_widget('notification/list', $data);
            }
        }
        catch(Exception $e)
        {
            $response['success'] = false;
            $response['status']  = 'error'; 
            $response['message'] = $e;
        }

        return $this->response->setJSON($response);
    }


    /**
     * Fetches and updates status of notifications, requests and messages
     * @return NULL     Echoes a json string containing the notifications
     */
    public function update_notices()
    { 
        $ntfn     = new Notifications;

        try 
        {
            $features = $this->request->getGet();

            $response['notif'] =
            $response['new_messages'] =
            $response['chats'] =
            $response['requests'] = FALSE;

            $param                    = ['recipient_id' => user_id(), 'type' => 'new'];
            $notifications            = $ntfn->getNotifications($param); 
            if ($notifications) {
                $response['notif']    = $notifications;
            }
            $response['requests']     = 0;
            $response['new_messages'] = 0;

            $response['success'] = true;
            $response['status']  = 'success';
        }
        catch(Exception $e)
        {
            $response['success'] = false;
            $response['status']  = 'error'; 
            $response['message'] = $e;
        }

        return $this->response->setJSON($response);
    } 


    /**
     * Receives a request from ajax and saves the current order of the items 
     * @return null     Does not return anything but echoes a JSON Object with a response
     */
    public function sortable()
    {   
        $items = $this->request->getPost();
        $i = 1;
        foreach ($items['item'] AS $item) 
        {
            $this->contentModel->save_content(['id' => $item, 'priority' => $i]);
            $i++;
        }
        return $this->response->setJSON(array('response' => TRUE));    
    } 


    /**
     * Saves parses and saves analytics data
     * @return null     Does not return anything but echoes a JSON Object with a response
     */
    public function save_analysis($metric = 'views')
    {  
        $data         = $this->request->getPost();
        $data['uid']  = user_id();
        $data['date'] = time();
        if (!user_id()) 
        {
            $data['uid'] = 0;
            $data['uip'] = $this->request->getIPAddress();
        }
        //print_r($data);echo $metric;
        $this->analyzeModel->t_post()->metric($metric)->add($data);
    }

    /**
     * Logs the user into webmail
     * @param  string   $employee_id    Id of the employee to delete
     * @return null                     Redirects to the employee list
     */
    function access_webmail($uid = '')
    {
        // Check if the user has permission to access this module and redirect to 401 if not 
        if ($this->util::loggedInIsAJAX(['uid' => $uid]) !== true)
            return $this->util::loggedInIsAJAX(['uid' => $uid]);

        $errors = "";
        $set_response['success'] = false;
        $set_response['status']  = 'error'; 
        $set_response['message'] = 'Connection Failed';

        $_user = $this->usersModel->get_user($uid);   

        $webmailer = Cpanel(my_config('cpanel_protocol'))->GET->Session->create_webmail_session_for_mail_user([
            'login'          => $_user['username'],  
            'locale'         => 'en',   
            'remote_address' => $this->request->getIPAddress(),   
            'domain'         => my_config('cpanel_domain')
        ]);

        if ($webmailer && empty($webmailer->data->errors) && !empty($webmailer->data->data->token)) 
        { 
            $set_response['success'] = true;
            $set_response['status']  = 'success'; 
            $set_response['message'] = 'Authenticated, you are being Redirected, Please Wait...';
            $set_response['session'] = $webmailer->data->data->session;
            $set_response['host']    = my_config('cpanel_protocol') . 's://' . my_config('cpanel_domain') . ':2096' . $webmailer->data->data->token . '/login';
            // $login = $this->curler->ssl_fetch($host, $post);
            // redirect($host);     
        } 
        elseif (!empty($webmailer->data->errors))
        {
            $set_response['message'] = CpanelErrors($webmailer->data->errors, 'Login'); 
        }
        else
        {
            $set_response['message'] = CpanelErrors(["Unable to connect..."], 'Login'); 
        }

        return $this->response->setJSON($set_response);
    } 


    /** 
     * @return null     Does not return anything but echoes a JSON Object with a response
     */
    public function generate_emails()
    {  
        if ($this->util::loggedInIsAJAX(true) !== true)
            return $this->util::loggedInIsAJAX(true);

        $errors = "";
        $alwm_id = null;
        $set_response['success'] = false;
        $set_response['status']  = 'error'; 
        $set_response['message'] = 'No changes made!';

        if ($uids = $this->request->getPost('uids')) 
        { 
            $emails_count = 0;
            foreach ($uids as $key => $uid) 
            {
                $_user  = $this->usersModel->get_user($uid); 
                $Cpanel = Cpanel(my_config('cpanel_protocol'));

                if (empty($Cpanel->errors)) 
                { 
                    if ($this->request->getPost('action') === 'generate') 
                    { 
                        // Check if this email has been generated before
                        if ($_user['cpanel'] !== '1') 
                        { 
                            $response = $Cpanel->GET->Email->list_pops(['skip_main'=>1]);
                            if (!empty($response->data->status)) 
                            {
                                // Check if this email account does not exist
                                if (!in_array("{$_user['username']}@" . my_config('cpanel_domain'), array_column(toArray($response->data->data), 'email')))
                                { 
                                    // Actually generate the accounts
                                    $add_pop = $Cpanel->GET->add_pop([
                                        'email'   => $_user['username'],
                                        'domain'  => my_config('cpanel_domain'),
                                        'password'=> my_config('default_password'),
                                        'send_welcome_email' => 1
                                    ]);
     
                                    if (!empty($add_pop->data->status)) 
                                    {
                                        $emails_count++;

                                        // Add new user to After logic
                                        $tenant = Alogic(my_config('afterlogic_protocol', null, 'http'), ['Module' => 'Core', 'Method' => 'GetTenantList']); 
                                        if (!empty($tenant->Result->Items[0]->Id)) 
                                        {
                                            $tenant_id = $tenant->Result->Items[0]->Id;
                                            $alwm_user = Alogic(my_config('afterlogic_protocol', null, 'http'), ['Module' => 'Core', 'Method' => 'CreateUser', 'Parameters' => [
                                                'TenantId' => $tenant_id, 
                                                'PublicId' => str_ireplace('+', '@', $add_pop->data->data), 
                                                'Role' => 2
                                            ]]);
                                            $alwm_id = $alwm_user->Result;
                                        }

                                        $this->usersModel->save_user(['uid' => $uid, 'cpanel' => '1', 'alwm_id' => $alwm_id]);
                                    }

                                    $errors .= CpanelErrors($add_pop->data->errors, $_user['username']);
                                }
                            }
                        }
                    }
                    elseif ($this->request->getPost('action') === 'delete')
                    { 
                        $response = $Cpanel->GET->Email->list_pops(['skip_main'=>1]);
                        if (!empty($response->data->status)) 
                        {
                            // Check if this email account does exist
                            if (in_array("{$_user['username']}@" . my_config('cpanel_domain'), array_column(toArray($response->data->data), 'email')))
                            { 
                                // Actually delete the accounts
                                $delete_pop = $Cpanel->GET->delete_pop([
                                    'email'  => $_user['username'], 
                                    'domain' => my_config('cpanel_domain')
                                ]);

                                if (!empty($delete_pop->data->status)) 
                                {
                                    $emails_count++;
                                    if ($_user['alwm_id']) 
                                    {
                                        Alogic(my_config('afterlogic_protocol', null, 'http'), ['Module' => 'Core', 'Method' => 'DeleteUser', 'Parameters' => [
                                                'UserId' => $_user['alwm_id']
                                            ]
                                        ]); 
                                    }
                                    $this->usersModel->save_user(['uid' => $uid, 'cpanel' => '0', 'alwm_id' => NULL]);
                                }  
                                    
                                $errors .= CpanelErrors($delete_pop->data->errors, $_user['username']);
                            }
                        }
                    }
                    elseif ($this->request->getPost('action') === 'alwm')
                    { 
                        if ($_user['cpanel'] && !$_user['alwm_id']) 
                        {
                            // Add new user to After logic
                            $tenant = Alogic(my_config('afterlogic_protocol', null, 'http'), ['Module' => 'Core', 'Method' => 'GetTenantList']); 
                            if (!empty($tenant->Result->Items[0]->Id)) 
                            {
                                $emails_count++;
                                $tenant_id = $tenant->Result->Items[0]->Id;
                                $alwm_user = Alogic(my_config('afterlogic_protocol', null, 'http'), ['Module' => 'Core', 'Method' => 'CreateUser', 'Parameters' => [
                                        'TenantId' => $tenant_id, 
                                        'PublicId' => $_user['username'] . '@' . my_config('cpanel_domain'), 
                                        'Role' => 2
                                    ]
                                ]);
                                $alwm_id = $alwm_user->Result;
                                $this->usersModel->save_user(['uid' => $uid, 'alwm_id' => $alwm_id]);
                            }
                        }
                    }
                }
                else
                {
                    $errors = $Cpanel->errors;
                }
            }
        } 

        if ($emails_count >= 1) 
        {
            $set_response['success'] = true;
            $set_response['status']  = 'success'; 
            $set_response['message'] = $emails_count . ' Email Accounts ' . ($this->request->getPost('action') === 'generate' ? 'generated!' : 'deleted!');
        }
        elseif ($errors) 
        {
            $set_response['message'] = $errors;
        }

        return $this->response->setJSON($set_response);
    } 

    /**
     * Allows for the upload of gallery media
     * @return null     Does not return anything but echoes a JSON Object with a response
     */
    public function upload_media()
    {   
        $ntfn = new Notifications;

        // Check if user is logged in and the method is accessed via ajax
        if ($this->util::loggedInIsAJAX() !== true)
            return $this->util::loggedInIsAJAX();

        $item       = $this->request->getPost();
        $item_type  = isset($item['type']) ? explode('/', $item['type'])[0] : null;

        $data       = [];
        $item_file  = $thumbnail_file = $description = NULL;

        // Check if this upload has a thumbnail
        $thumbnail = $this->request->getPost('thumbnail');

        $data['success'] = false;
        $data['status']  = 'error'; 

        // Get the item thumbnail if available
        if ($thumbnail && empty($error)) 
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
                    if ( ! $this->creative->create_dir($upload_path))
                    {
                        $error = 'The thumbnail destination folder does not appear to be writable.'; 
                    }
                    else
                    {
                        // $this->creative->delete_file('./' . $data[$table_index]);

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

            $item_files = $this->creative->upload('file', NULL, $new_name,  NULL, [1000,1000]); 
            if ($this->creative->upload_errors('file') !== FALSE)
            {
                $error = $this->creative->upload_errors('file', '','');
            }
            else
            {
                $item_file = $item_files['new_path'];
            }
        }

        // Get the item description
        if (!empty($item['description']) || !empty($item['title'])) 
        {
            $description = $item['description']; 
            $title       = $item['title']; 
            $featured    = $item['featured']; 
        }
        elseif (empty($item_file) && empty($post['feature'])) 
        {
            $error = 'Unable to save empty item.';
        }

        // Prepare and save the data to the database
        if (empty($error)) 
        {
            $uid = (isset($item['uid'])) ? $item['uid'] : user_id(); 

            if (!empty($item['item_id'])) 
            {
                $save_item = [  
                    'item_id'   => $item['item_id'], 
                    'title'     => $title,
                    'details'   => $description, 
                    'featured'  => $featured
                ]; 
                $data['message'] = 'Your item has been updated!'; 
            }
            else
            {
                $save_item = [
                    'getId'     => true,  
                    'title'     => $title,
                    'details'   => $description,
                    'file'      => $item_file,  
                    'thumbnail' => $thumbnail_file, 
                    'type'      => $item_type, 
                    'featured'  => $featured
                ]; 
                $data['message'] = 'Your item has been published!'; 
            } 
            
            $save_item['uid']   = $uid; 

            $saved_id = $this->contentModel->save_gallery($save_item);

            $data['success'] = true;
            $data['status']  = 'success';

            $item_id  = (!empty($item['item_id'])) ? $item['item_id'] : $saved_id;

            if ($saved_id && $item_id !== true)
            {  
                $get_item = $this->contentModel->get_features(['id' => $item_id], 'gallery');
                // $data['html'] = load_widget('posts/item', ['post'=>$get_item]);
            }

            $this->response->setStatusCode(200);
        }

        if (!empty($error)) 
        {
            $data['message'] = $error;
            $this->response->setStatusCode(500);
        }

        return $this->response->setJSON($data);    
    } 
}