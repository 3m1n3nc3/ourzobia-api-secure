<?php namespace App\Models;

use CodeIgniter\Model;

class ProductsModel extends Model
{ 
    protected $db;
    protected $table      = 'all_products';
    protected $primaryKey = 'id';

    protected $returnType = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = [
    	'name', 'domain', 'email', 'code', 'status'];

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

    public function get_all($status = 1)
    {  
        $this->select('all_products.*, users.uid');
        if ($status) 
        {
            $this->where('all_products.status', $status); 
        }
        $this->join('users', 'all_products.uid=users.uid', 'LEFT');  
        return $this->orderBy('id', 'ASC')->findAll();
    } 

    public function check(array $data = [])
    {  
        $this->select('all_products.*, users.uid');
        $this->where('all_products.status', 1); 
        $this->where('all_products.domain', $data['domain']??''); 
        $this->where('all_products.email', $data['email']); 
        $this->where('all_products.code', $data['code']);  
        $this->join('users', 'all_products.uid=users.uid', 'LEFT');  

        return $this->find();
    } 

    public function remove(array $data = [])
    { 
        return $this->delete($data['id'], true);
    }
}
