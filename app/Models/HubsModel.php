<?php namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Database\ConnectionInterface;

class HubsModel extends Model
{ 
    protected $db;

    protected $returnType = 'array';   

    public function get_hub($data = array(), $table = 'hub_types')
    {   
        $hubs = $this->db->table($table); 

        if ($table === 'hubs') 
        {
            $hubs->select('hub_types.*,hubs.id,hubs.hub_type,hubs.hub_no,hubs.status');
            $hubs->join('hub_types', 'hub_types.id=hubs.hub_type', 'LEFT'); 
        }
        else
        {
            $hubs->select('*');
        }

        if (isset($data['status'])) 
        {
            $hubs->where('status', $data['status']); 
        }

        if (array_key_exists('id', $data))
        {
            return $hubs->where($table . '.id', $data['id'])->get()->getRowArray();
        }
         
        $hubs->orderBy('priority ASC');

        return $hubs->get()->getResultArray();
    }  


    public function save_hub($data = array(), $table = 'hub_types')
    {   
        $hubs = $this->db->table($table);
        $allowed_rows = [
            'hub_types' => ['name', 'seats', 'icon', 'description', 'duration', 'facilities', 'price', 'image', 'status', 'id'],
            'hubs'      => ['hub_type', 'hub_no', 'status', 'id']
        ];
        
        $save = array(); 
        foreach ($data as $key => $value) 
        {
            if (in_array($key, $allowed_rows[$table])) 
            {
               $save[$key] = $value;
            }
        }

        if (!empty($data['id'])) 
        {
            $save['id'] = $data['id'];
            if ($hubs->where('id', $data['id'])->update($save)) return $data['id'];
        }

        $hubs->insert($save);
        return $this->db->insertID(); 
    } 

    /**
     * This function will take the post data passed from the controller
     * If id is present, then it will do an update
     * else an insert. One function doing both add and edit.
     * @param $data
     */
    public function save_content($data) 
    {
        $content = $this->db->table('content');

        if (isset($data['id'])) 
        { 
            if ($content->where('id', $data['id'])->update($data)) return $data['id'];
        } 
        else 
        {
            $content->insert($data);
            return $this->db->insertID(); 
        }
    }    

    public function cancel_hub(array $data = [])
    {   
        if (!empty($data['table'])) 
        {
            $delete = $this->db->table($data['table']);
            unset($data['table']); 
            return $delete->delete($data, true);
        }
    } 
} 
