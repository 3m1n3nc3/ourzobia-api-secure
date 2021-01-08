<?php namespace App\Models;

use CodeIgniter\Model;

class MainProductsModel extends Model
{
    protected $db;
    protected $table      = 'products';
    protected $primaryKey = 'id';

    protected $returnType = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['uid', 'title', 'name', 'licenses', 'status'];

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

    public function get_products(array $data = [])
    {  
        $this->select('*');
        
        if (!empty($data['status']))
        { 
            $this->where('status', $data['status']); 
        } 
        
        if (!empty($data['title']))
        {
            $this->getWhere(['title'=>$data['title']]);// echo $this->getLastQuery();
            return $this->find()[0]??[];
        } 
        
        if (!empty($data['id']))
        { 
            $this->getWhere(['id'=>$data['id']]); 
            return $this->find()[0]??[];
        } 
        
        if (!empty($data['uid']))
        { 
            $this->getWhere(['uid'=>$data['uid']]); 
            return $this->find()[0]??[];
        } 

        return $this->orderBy('id', 'ASC')->findAll();
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
