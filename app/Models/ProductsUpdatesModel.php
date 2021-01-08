<?php namespace App\Models;

use CodeIgniter\Model;
use \App\Libraries\Creative_lib;

class ProductsUpdatesModel extends Model
{
    protected $db;
    protected $table      = 'product_updates';
    protected $primaryKey = 'id';

    protected $returnType = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['uid', 'pid', 'token', 'title', 'message', 'type', 'file', 'status'];

	protected $useTimestamps = true;
	protected $dateFormat    = 'int'; 
    protected $deletedField  = 'deleted'; 
    protected $updatedField  = 'updated'; 
    protected $createdField  = 'date'; 

    public function create($data = array())
    {
        if (isset($data['id'])) 
        {
            if ($this->save($data))
                return $data['id'];
        }
        else 
        {
            $this->insert($data);
            return $this->insertID();
        } 
    }  

    public function get_updates(array $data = [])
    {  
        $this->select('*');
        
        if (!empty($data['status']))
        { 
            $this->where('status', $data['status']); 
        } 
        
        if (!empty($data['pid']))
        {  
            $this->where('pid', $data['pid']);  
        } 
        
        if (!empty($data['type']))
        {  
            $this->where('type', $data['type']);  
        } 
        
        if (!empty($data['title']))
        {
            $this->where(['title'=>$data['title']]);// echo $this->getLastQuery();
            return $this->get()->getRowArray();
        } 
        
        if (!empty($data['id']))
        {  
            return $this->find($data['id'])??[];
        } 
        
        if (!empty($data['uid']))
        { 
            $this->where(['uid'=>$data['uid']]); 
            return $this->get()->getRowArray();
        } 

        return $this->orderBy('id', 'ASC')->findAll();
    }    

    public function remove($data = [])
    { 
        $id = (is_array($data)) ? $data['id'] : $data;

        $update   = $this->find($id);

        if (!empty($update['file']))
        { 
            $creative = new Creative_lib; 
            $creative->delete_file('./' . $update['file']);
        }
        return $this->delete($id, true);
    }

    public function cancel($data = [])
    { 
        $id = (is_array($data)) ? $data['id'] : $data;
        return $this->remove($id);
    }
}
