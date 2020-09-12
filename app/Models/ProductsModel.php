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
        if ($status) 
        {
            $this->where('status', $status); 
        }
        return $this->orderBy('id', 'ASC')->findAll();
    } 

    public function check(array $data = [])
    {  
        $this->where('status', 1); 
        $this->where('domain', $data['domain']??''); 
        $this->where('email', $data['email']); 
        $this->where('code', $data['code']);  

        return $this->find();
    } 

    public function remove(array $data = [])
    { 
        return $this->delete($data['id'], true);
    }
}
