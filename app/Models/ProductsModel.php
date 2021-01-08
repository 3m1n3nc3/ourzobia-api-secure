<?php namespace App\Models;

use CodeIgniter\Model;

class ProductsModel extends Model
{ 
    protected $db;
    protected $table      = 'all_products';
    protected $primaryKey = 'id';

    protected $returnType = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['uid', 'name', 'domain', 'email', 'code', 'status', 'license_type', 'expiry'];

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

    public function codeGet($code = null)
    {   
        return $this->getWhere(['code'=>$code])->getRowArray();
    } 

    public function get_product($data = [])
    {   
        if (!empty($data['id']))
        {
            return $this->find($data['id']); 
        }

        if (!empty($data['name']))
        {
            $this->where('all_products.name', $data['name']); 
        }

        return $this->get()->getRowArray();
    } 

    public function getDomain($domain = null)
    {   
        return $this->getWhere(['domain'=>$domain])->getRowArray();
    } 

    public function check(array $data = [])
    {
        $pmdl = model('App\Models\ProductsModel', false);

        $this->select('all_products.*, users.uid');
        $this->where('all_products.status', 1);  
        if (!empty($pmdl->codeGet($data['code']??'')['domain'])) 
        {
            $this->where('all_products.domain', $data['domain']??''); 
        }
        $this->where('all_products.email', $data['email']??''); 
        $this->where('all_products.code', $data['code']??''); 

        if (!empty($data['product']))
        {
            $this->where('all_products.name', $data['product']);  
        }
        
        $this->join('users', 'all_products.uid=users.uid', 'LEFT');  

        return $this->get()->getRowArray();
    } 

    public function remove($data = [])
    { 
        $id = (is_array($data)) ? $data['id'] : $data;
        return $this->delete($id, true);
    }

    public function cancel($data = [])
    { 
        $id = (is_array($data)) ? $data['id'] : $data;
        return $this->remove($id);
    }
}
