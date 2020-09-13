<?php namespace App\Libraries; 

use CodeIgniter\Model;


class Notifications {
    public $type = null;

    public $notifier_id = null; 

    function __construct() 
    { 
        $this->db       = \Config\Database::connect()->table('notifications'); 
        $this->acc_data = new \App\Libraries\Account_Data;
    }

    /** 
     *
     * Sends a notification to the specified user
     *
     * @param   array      $data    [recipient_id]: The id of the receiver of the notification 
     *                              [notifier_id]: The id of the sender of the notification 
     *                              [type]: The type of the notification
     * @return  null
     */
    public function notify($data = array()){
        global $config;
        if (empty($data) || !is_array($data)) 
        {
            return false;
        }
        
        $this->db->where('notifier_id', $data['notifier_id']);
        $this->db->where('recipient_id', $data['recipient_id']);
        $this->db->where('type', $data['type']); 
        $this->db->delete();
 
        $data['text'] = !empty($data['text']) ? $data['text'] : '';  
        $this->db->insert($data); 
    } 


    /** 
     *
     * Checks if the notification to view requires a session to be set and sets it
     * @param   object      $notifs     An Object or array containing the notifications
     * @return  null
     */
    function setNotificationSession($notifs = array()) {
        if ($notifs) 
        {
            foreach ($notifs as $key => $notif) 
            {  
                $explode = explode('.', $notif->type);
                if (count($explode)===4) 
                {
                    $notifs[$key]->type = $explode[0];
                    
                    if ($explode[1] === 'ss') 
                    {
                        $e_key = $explode[3]; 
                        $_SESSION[$explode[2]] = $notif->$e_key;  
                    }
                }
            }
        }
        return $notifs;
    }


    /** 
     *
     * Gets all the notifications for the specified user
     *
     * @param   array      $query   [recipient_id]: The logged in user or receiver of the notification 
     *                              [type]: Possible values [new,all]
     * @return  null
     */
    function getNotifications($param = array(), $offset = false)
    {
        if (empty($param['recipient_id']))
        {
            return false;
        }
 
        $user_id = $param['recipient_id'];
        $limit   = 10;
        $data    = array();
        $update  = array();
        
        $this->db->where('recipient_id', $user_id);

        if ($param['type'] == 'new') 
        {
            $data = $this->db->where('seen', NULL)->countAllResults(); 
        }
        else
        {  
            $this->db->select('notifications.*, u.username, u.avatar');
            $this->db->join("users u","notifications.notifier_id = u.uid ","INNER"); 

            if (!empty($offset))
            {
                $this->db->limit(15, $offset);
            }

            $this->db->orderBy('id', 'DESC');

            if (!empty($param['page'])) 
            {
                $perpage = (my_config('perpage')) ? my_config('perpage') : 10;
                $query = $this->db->paginate($perpage);
            } 
            else
            {
                $query = $this->db->get()->getResult();
            }

            if (!empty($query)) 
            {
                foreach ($query as $notif_data) 
                {  
                    $data[]   = $notif_data;
                    $update[] = $notif_data->id;
                }

                $this->db->whereIn('id', $update)->update(array('seen' => time()));
            }

            $data = $this->setNotificationSession($data);  
        }

        return $data;
    } 

    function setSeen($id)
    {
        return $this->db->where('id', $id)->where('seen', NULL)->update(array('seen' => time()));
    } 

    /** 
     *
     * Sends the notification to all moderators with the required privilege
     *
     * @param   array      $data    [type]: The type of notification to send   
     *                              [url]: The url for the notification
     * @return  null
     */
    public function notifyAdmins($data = array())
    {
        $users_m   = model('App\Models\UsersModel', false); 

        if (!$this->acc_data->logged_in() || empty($data['url'])) {
            // return false;
        }

        $level = isset($data['level']) ? $data['level'] : 2;

        $users = $users_m->get_user(['admin'=>$level]); 

        $user_id   = user_id();

        if (!empty($data['user_id'])) 
        {
            $user_id = $data['user_id'];
        }

        $type = isset($data['type']) ? $data['type'] : null;
        $text = isset($data['text']) ? $data['text'] : null;

        foreach ($users as $user) 
        {
            try 
            { 
                $privileged_uid = $user['uid']; 

                if ($privileged_uid/* && $privileged_uid != $user_id*/) 
                {
                    $nt_data = array(
                        'notifier_id' => $user_id,
                        'recipient_id' => $privileged_uid,
                        'type' => $type,
                        'text' => $text,
                        'url' => $data['url'],
                        'time' => time()
                    ); 

                    $this->notify($nt_data);
                }
            } 
            catch (Exception $e) {
                echo $e;
            }
        }
    }


    public function clearNotifications($data = array())
    { 
        if (empty($data['recipient_id']))
        {
            return false;
        } 

        if (!empty($data['notifier_id']) && is_numeric($data['notifier_id'])) 
        {
            $this->db->where('notifier_id', $data['notifier_id']);
            $this->db->where('recipient_id', $data['recipient_id']);    
        }
        else
        {
            $this->db->where('recipient_id', $data['recipient_id']);
            $this->db->where('time', (time() - 432000));
            $this->db->where('seen >', 0);
        }
        return $this->db->delete();
    }  
}
