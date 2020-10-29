<?php namespace App\Models;

use CodeIgniter\Model;

class LocaleModel extends Model
{ 
    protected $db;   

    protected $returnType = 'array';   


    public function fetch_cities($id, $column = null)
    { 
    	$data = $this->db->table('cities')->select('*')->where('state_id', $id)->get()->getResultArray();

    	if ($column) 
    	{
    		return $data[$column];
    	}

    	return $data;
    }

    public function fetch_states($id, $column = null)
    { 
        $data = $this->db->table('states')->select('*')->where('country_id', $id)->get()->getResultArray();

        if ($column) 
        {
            return $data[$column];
        }

        return $data;
    }

    public function fetch_countries($column = null, $sort = 'id')
    { 
        $data = $this->db->table('countries')->select('*')->orderBy($sort)->get()->getResultArray(); 

        if ($column) 
        {
            return $data[$column];
        }

        return $data;
    } 
}
