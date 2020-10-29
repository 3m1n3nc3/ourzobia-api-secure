<?php namespace App\Models;

use CodeIgniter\Model;

class SettingsModel extends Model
{ 
    protected $db;
    protected $table      = 'settings';
    protected $primaryKey = 'setting_key';

    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'setting_key', 'settind_value'];

    protected $useTimestamps = false;   

    /**
     * This function will return the configuration settings from the db
     * If key is not provided, then it will fetch all the records form the table.
     * @param string $key
     * @return mixed
     */
    public function get_settings($key = null) 
    {
        $this->select('setting_key, setting_value');
        if (!empty($key)) 
        {
            $this->where('setting_key', $key); 
        } 
        else 
        {
            $this->orderBy('setting_key');
        }

        $query   = $this->get();
        $setting = $query->getRowArray();
        
        if (isset($key)) 
        { 
           return isset($setting['setting_value']) ? $setting['setting_value'] : null;
        } 
        else
        {
            return $query->getResultArray();;
        }
    }

    public function save_settings($data) 
    {
        if (env('installation.demo', false) === false || logged_user('admin')>=3) 
        { 
            $insert_id = [];
            foreach (array_keys($data) as $setting_key) 
            {
                if ($this->get_settings($setting_key) !== NULL) 
                { 
                    $setting = array('setting_value' => $data[$setting_key]); 
                    $return  = $this->builder->where('setting_key', $setting_key)->set($setting)->update();  
                }
                else 
                {
                    $setting = array('setting_key' => $setting_key, 'setting_value' => $data[$setting_key]);
                    $return  = $this->builder->insert($setting); 
                }
            }  
            return $return;
        }
        else
        {
            return ['msg' => _lang('cant_do_in_demo', ['update configuration'])]; 
        } 
    }    
}
