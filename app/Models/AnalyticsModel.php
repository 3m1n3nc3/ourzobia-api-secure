<?php namespace App\Models;

use CodeIgniter\Model;

class AnalyticsModel extends Model
{ 
    protected $db;
    protected $table      = 'analytics';
    protected $primaryKey = 'id';

    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
    	'item_id', 'uid', 'uip', 'ip_info', 'type', 'metric', 'referrer', 'date'];

	protected $useTimestamps = false;  


    public function metric($metric) 
    {
        $this->metric = $metric;
        return $this;
    }

    public function t_product() 
    {
        $this->type = 'product';
        return $this;
    }

    public function t_site() 
    {
        $this->type = 'site';
        return $this;
    }

    public function m_activation() 
    {
        $this->metric = 'activations';
        return $this;
    }

    public function m_validation() 
    {
        $this->metric = 'validations';
        return $this;
    }

    public function m_visit() 
    {
        $this->metric = 'visits';
        return $this;
    }

    public function m_share() 
    {
        $this->metric = 'shares';
        return $this;
    }

    public function _item($id) 
    {
        $this->item = $id;
        return $this;
    }

    public function add($data = array())
    {
        if (isset($this->type))
        {
            $data['type'] = $this->type;
        }

        if (isset($this->metric)) 
        {
            $data['metric'] = $this->metric;
        }

        if (isset($data['uip']))
        {
            $data['ip_info'] = (localhosted(my_config('offline_access'))) ? IpApi($data['uip'])->rawBodyData : null;
        }

        if (isset($data['id'])) {
            if ($this->save($data))
                return $data['id'];
        }
        else 
        {
            $this->insert($data);
            return $this->insertID();
        }  
    } 

    public function analyze($data = [])
    {  
        $this->analysis($data);
        $this->select('*');

        $id   = isset($data['id']) ? $data['id'] : null;
        $data = $this->find($id);
 
        if (!empty($data['col']))
        {
            return $data[$data['col']];
        }

        return $data;
    }

    public function charts($week = null, $from = null, $to = null)
    {
        $counter = $this->select('count(`id`)')->where('DATE(FROM_UNIXTIME(date)) = dated', NULL, FALSE)->getCompiledSelect();

        $this->select("DATE(FROM_UNIXTIME(date)) dated, ($counter) count");
        
        if (!empty($from) && !empty($to)) 
        {
            $this->where("DATE(FROM_UNIXTIME(date)) >= DATE('{$from}') AND DATE(FROM_UNIXTIME(date)) <= DATE('{$to}')");
        }
        elseif (is_numeric($week)) 
        {
            $this->where("WEEK(DATE(FROM_UNIXTIME(date))) = WEEK(CURDATE())-{$week} AND YEAR( DATE(FROM_UNIXTIME(date))) = YEAR(CURDATE())");
        } 
        elseif ($week === 'm') 
        {
            $this->where("MONTH(DATE(FROM_UNIXTIME(date))) = MONTH(CURDATE()) AND YEAR(DATE(FROM_UNIXTIME(date))) = YEAR(CURDATE())");
        }
 
        $stats = $this->groupBy('dated')->orderBy('MONTH(dated)', 'ASC')->orderBy('DAY(dated)', 'ASC')->get()->getResultArray(); 
        // echo $this->getLastQuery();

        return $stats;
    } 

    public function unique_visits($data = [])
    {  
        $this->analysis($data);
        $this->select('uid');
        $this->groupBy('uid');
        $this->groupBy('uip');
        return $this->countAllResults();
    }

    public function impression_visits($data = [])
    {  
        $this->analysis($data);
        return $this->countAllResults();
    }

    public function analysis($data = [])
    {   
        if (isset($this->type)) 
        {
            $data['type'] = $this->type;
        }

        if (isset($this->metric)) 
        {
            $data['metric'] = $this->metric;
        }

        if (isset($this->item)) 
        {
            $data['item_id'] = $this->item;
        }

        if (!empty($data['type'])) 
        {
            $this->where(['type' => $data['type']]);
        }

        if (!empty($data['item_id'])) 
        {
            $this->where(['item_id' => $data['item_id']]);
        }

        if (!empty($data['metric'])) 
        {
            $this->where(['metric' => $data['metric']]);
        }

        if (!empty($data['referrer'])) 
        {
            $this->where(['referrer' => $data['referrer']]);
        }

        if (!empty($data['uid'])) 
        {
            $this->where(['uid' => $data['uid']]);
        }

        return $this;
    } 
}
