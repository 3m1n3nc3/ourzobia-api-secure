<?php namespace App\Models;

use CodeIgniter\Model;

class ActivesModel extends Model
{ 
    protected $db;
    protected $table      = 'active_products';
    protected $primaryKey = 'id';

    protected $returnType = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields  = ['domain', 'status'];

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
        $this->select('active_products.*, all_products.id');
        if ($status) 
        {
            $this->where('status', $status); 
        }
        $this->join('users', 'active_products.product_id=all_products.id', 'LEFT');  
        return $this->orderBy('id', 'ASC')->findAll();
    } 

    public function check(string $domain)
    {  
        $this->select('active_products.*, all_products.id AS pid');
        $this->where('active_products.status', 1); 
        $this->where('active_products.domain', $domain);  
        $this->join('all_products', 'active_products.product_id=all_products.id', 'LEFT');  

        return $this->find();
    } 

    public function remove(array $data = [])
    { 
        return $this->delete($data['id'], true);
    }
}
