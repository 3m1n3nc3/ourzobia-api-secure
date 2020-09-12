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
        if ($status) 
        {
            $this->where('status', $status); 
        }
        return $this->orderBy('id', 'ASC')->findAll();
    } 

    public function check(string $domain)
    {  
        $this->where('status', 1); 
        $this->where('domain', $domain);  

        return $this->find();
    } 

    public function remove(array $data = [])
    { 
        return $this->delete($data['id'], true);
    }
}
