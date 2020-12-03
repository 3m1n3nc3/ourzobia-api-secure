<?php namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\CLI\CLI AS CLINT;

class UsersModel extends Model
{ 
    protected $db;
    protected $table      = 'users';
    protected $primaryKey = 'uid';

    protected $returnType = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = [
    	'uip', 'username', 'email', 'phone_code', 'phone_number', 'fullname', 'avatar', 'admin', 'password', 'status', 'cpanel'
        , 'alwm_id', 'token'
    ];

	protected $useTimestamps = true;
	protected $dateFormat    = 'int';
    protected $createdField  = 'reg_time';
    protected $updatedField  = 'last_update';
    protected $deletedField  = 'deleted';

    // public function __construct(ConnectionInterface &$db)
    // {
    //     $this->db =& $db;
    // } 

    public function save_user($data = array())
    {
        if (isset($data['uid'])) 
        {
            if ($this->update($data['uid'], $data))
                return $data['uid'];
        }
    	else 
    	{
	        $this->insert($data);
	        return $this->insertID();
	    }
    }   

    public function get_user($uid = null)
    {  
        $this->select("users.*");

        if (!empty($uid) && !is_numeric($uid) && !is_array($uid)) 
        {
            return $this->groupStart()
                ->where('username', $uid)
                ->orWhere('email', $uid)
            ->groupEnd()->get()->getRowArray(); 
        }

        if (!empty($uid['admin'])) 
        {
            return $this->where('admin>=', $uid['admin'])->first(); 
        }

        if (!empty($uid['uip'])) 
        {
            return $this->where('uip', $uid['uip'])->first(); 
        }

        return $this->find($uid);
    } 

    public function get_user_relevant($uid = null, $query = [])
    {  
        $this->select("uid, username, email, CONCAT_WS('',phone_code,phone_number) AS phone_number, admin, status"); 

        $query = $this->find($uid);
        return $query;
    }     

    public function user_by_username($username)
    {
        return $this->where('username', $username)
            ->orWhere('email', $username)->get()->getRowArray();
    }

    public function user_by_token($token)
    {
        $user = $data = $this->getWhere(['token' => $token, 'token !=' => NULL])->getRowArray();
        if (!empty($user['uid'])) 
        {
            return $this->get_user($user['uid']);
        }
    } 

    public function cancel(array $data = [])
    { 
        if ($this->find($data['id']))
        {
            if ($this->delete($data['id'], true))
            { 
                
                return ['msg' => 'User has been deleted successfuly'];
            }
        }  
    }
}
