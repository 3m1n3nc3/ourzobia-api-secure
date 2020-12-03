<?php namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Database\ConnectionInterface;

class ContentModel extends Model
{ 
    protected $db;

    protected $returnType = 'array';   

    public function get_features($data = array(), $table = 'features')
    {   
        $features = $this->db->table($table);
        $features->select('*');

        if (isset($data['type'])) 
        {
            $features->where('type', $data['type']); 
        }

        if (isset($data['featured'])) 
        {
            $features->where('featured', $data['featured']); 
        }

        if (array_key_exists('id', $data))
        {
            return $features->where('id', $data['id'])->get()->getRowArray();
        }

        if ($table === 'features') 
        {
            $features->orderBy('type ASC');
            $features->orderBy('priority ASC');
        }

        return $features->get()->getResultArray();
    } 


    public function get_content($data = array(), $row = 0)
    {   
        $content = $this->db->table('content');  

        $content->select('*');

        if (isset($data['safelink'])) 
        {
            $content->where('safelink', $data['safelink']); 
        }

        if (isset($data['or_id'])) 
        {
            $content->orWhere('id', $data['or_id']); 
        }

        if (isset($data['id'])) 
        {
            $content->where('id', $data['id']); 
        }

        if (isset($data['or_safelink'])) 
        {
            $content->orWhere('safelink', $data['or_safelink']); 
        }

        if (isset($data['priority'])) 
        {
            $content->where('priority', $data['priority']); 
        }

        if (isset($data['section'])) 
        {
            $content->where('section', $data['section']); 
        }

        if (isset($data['in']) || isset($data['not_in'])) 
        {
            $in    = isset($data['in']) ? '1' : '0';
            $where = isset($data['in']) ? 'in_'.$data['in'] : 'in_'.$data['not_in'];

            $content->where($where, $in); 
        }

        if (isset($data['parent'])) 
        {
            $content->groupStart(); 
            if ($data['parent'] == 'non' || $data['parent'] == 'null') 
            {
                $content->where('parent IS NULL'); 
                $content->orWhere('parent', '0'); 
                $content->orWhere('parent', ''); 
            }
            elseif ($data['parent'] == 'set' || $data['parent'] == 'not_null') 
            {
                $content->where('parent IS NOT NULL'); 
                $content->where('parent !=', '0'); 
                $content->where('parent !=', ''); 
            }
            else
            {
                $content->where('parent', $data['parent']); 
            }
            $content->groupEnd(); 
        }  

        if (!isset($data['safelink']) && !isset($data['id'])) 
        {
            if (isset($data['order_field']))  
            {
                $content->orderBy('FIELD(`'.$data["order_field"]["name"].'`, "'.$data["order_field"]["id"].'") DESC'); 
            }
            else
            {
                $content->orderBy('priority ASC');
            }
        }
 
        $query = $content->get();
        if (isset($data['safelink']) || isset($data['id']) || $row) 
        {
            return $query->getRowArray();
        } 
        else 
        {
            return $query->getResultArray();
        }
    }



    /**
     * This function will return the content from the db
     * If key is not provided, then it will fetch all the records form the table.
     * @param string $key
     * @return mixed
     */
    public function get_parent($data = null, $row = 0) 
    {
        $content = $this->db->table('content');

        $content->select('parent'); 

        if (isset($data['parent']) && !empty($data['parent'])) 
        {
            $content->where('parent', $data['parent']); 
            $content->where('parent NOT NUL'); 
        } 

        $content->groupBy('parent');
        $content->orderBy('parent DESC');
 
        $query = $content->get();
        if (isset($data['safelink']) || isset($data['id'])) 
        {
            return $query->getRowArray();
        } 
        else 
        {
            return $query->getResultArray();
        }
    }


    public function save_features($data = array())
    {   
        $features = $this->db->table('features'); 
        
        $save = array(); 
        foreach ($data as $key => $value) 
        {
            if (in_array($key, ['title', 'type', 'icon', 'details', 'button', 'image', 'id'])) 
            {
               $save[$key] = $value;
            }
        }

        if (!empty($data['id'])) 
        {
            $save['id'] = $data['id'];
            if ($features->where('id', $data['id'])->update($save)) return $data['id'];
        }

        $features->insert($save);
        return $this->db->insertID(); 
    }


    public function save_gallery($data = array())
    {   
        $gallery = $this->db->table('gallery'); 

        $save = array();  
        foreach ($data as $key => $value) 
        {
            if (in_array($key, ['title', 'type', 'thumbnail', 'details', 'featured', 'file', 'category', 'id'])) 
            {
               $save[$key] = $value;
            }
        }

        if (!empty($data['id'])) 
        {
            $save['id'] = $data['id'];
            if ($gallery->where('id', $data['id'])->update($save)) return $data['id'];
        }

        $gallery->insert($save);
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


    /**
     * This function will update the parent for all content when the parent item is updated
     * else an insert. One function doing both add and edit.
     * @param $data
     */
    public function update_parent($data) 
    {
        $content = $this->db->table('content');

        if (isset($data['parent'])) 
        {
            $content->where('parent', $data['safelink']);
            $content->update(['parent' => $data['parent']]);
            return $this->db->affectedRows();
        }
    }  

    public function cancel_feature(array $data = [])
    { 
        return $this->db->table('features')->delete($data, true);
    }

    public function cancel_gallery(array $data = [])
    { 
        return $this->db->table('gallery')->delete($data, true);
    }

    public function cancel_content(array $data = [])
    { 
        return $this->db->table('content')->delete($data, true);
    }
} 
