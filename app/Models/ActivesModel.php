<?php namespace App\Models;

use CodeIgniter\Model;

class ActivesModel extends Model
{ 
    protected $db;
    protected $table      = 'active_products';
    protected $primaryKey = 'id';

    protected $returnType = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields  = ['product_id', 'domain', 'license_type', 'status', 'expiry'];

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

    public function check($domain = '', $product = '', $license_type = '')
    {  
        $this->select('active_products.*, all_products.domain, all_products.license_type, all_products.name, all_products.id AS pid');
        $this->where('active_products.status', 1); 
        $this->where('all_products.domain', $domain);
        $this->where('DATE(FROM_UNIXTIME(all_products.expiry)) >= CURDATE()');

        if ($product) 
        {
            $this->where('all_products.name', $product);  
        }

        if ($license_type) 
        {
            $this->where('all_products.license_type', $license_type); 
        }
 
        $this->join('all_products', 'active_products.product_id=all_products.id', 'LEFT');  

        return $this->get()->getRowArray();
    } 

    public function remove(array $data = [])
    { 
        return $this->delete($data['id'], true);
    }
}
