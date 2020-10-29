<?php namespace App\Models;

use CodeIgniter\Model;

class BookingsModel  extends Model
{ 
    protected $db;
    protected $table      = 'hub_bookings';
    protected $primaryKey = 'id';

    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['uid', 'hub_id', 'checkin_date', 'checkout_date', 'duration', 'amount', 'status'];

	protected $useTimestamps = true;
	protected $dateFormat    = 'int';  
    protected $createdField  = 'date'; 
    protected $updatedField  = false; 
    protected $deletedField  = false; 

    protected $perpage    = 10;

    public function book($data = array())
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

    public function record_payment($data = array(), $table = "payments")
    { 
        $payment = $this->db->table($table);

        if (isset($data['id'])) 
        { 
            if ($payment->where('id', $data['id'])->update($data)) return $data['id'];
        }
        else
        {
            $payment->insert($data);
            return $this->db->insertID(); 
        } 
    }  

    public function get_all($data = [])
    {  
        $this->select('hub_bookings.*, hubs.hub_no, hubs.hub_type, hub_types.name, hub_types.duration hub_duration');

        $this->join('hubs', 'hub_bookings.hub_id=hubs.id', 'LEFT');  
        $this->join('hub_types', 'hubs.hub_type=hub_types.id', 'LEFT');  

        if (isset($data['status'])) 
        {
            $this->where('hub_bookings.status', $data['status']); 
        } 
            
        if (isset($data['uid']))
        {
            $this->where('uid', $data['uid']); 
        }  
            
        if (isset($data['id']))
        {
            $this->where('hub_bookings.id', $data['id']); 
            return $this->get()->getRowArray();
        }  
        else
        {
            return $this->orderBy('checkin_date', 'DESC')->paginate($this->perpage);
        } 

        return $this->orderBy('checkin_date', 'ASC')->findAll();
    }  


    /**
     * Get all hubs that have not been booked for the specified period.
     * The $data parameters `from` and `to` are required datetime string. E.g date('Y-m-d H:i:s', strtotime("NOW"))
     * @param  string   $data     An array containing all the parameters
     * @param  string   $count    Determines whether to return a results array or count, alternatively add this from $data parameters
     * @return array|string       
     */
    public function check(array $data = [])
    { 
        if (!empty($data['from']) && !empty($data['to']))
        {
            $from = $data['from'];
            $to   = $data['to'];

            if (is_numeric($data['from']))
            {
                $from = date('Y-m-d H:i:s', strtotime($data['from']));
            }

            if (is_numeric($data['to']))
            {
                $to = date('Y-m-d H:i:s', strtotime($data['to']));
            }

            $tbh = $this->db->table('hubs')->select('hubs.*, hub_types.duration, hub_types.price, hub_types.seats');
     
            if (isset($data['hub_type']))
            {
                $tbh->where('hub_types.id', $data['hub_type']);
            }   
            
            if (isset($data['status']))
            {
                $tbh->where('hubs.status', $data['status']);
                $tbh->where('hub_types.status', $data['status']);
            }  

            $tbh->groupStart()
                ->whereNotIn('hubs.id', function() use ($from, $to)
                {
                    $this->select('hub_id');
                    $this->where("DATE(FROM_UNIXTIME(checkin_date)) >= DATE('{$from}') AND DATE(FROM_UNIXTIME(checkin_date)) <= DATE('{$to}')");
                    return $this->where("DATE(FROM_UNIXTIME(checkout_date)) >= DATE('{$from}') AND DATE(FROM_UNIXTIME(checkout_date)) <= DATE('{$to}')");
                })
            ->groupEnd()
            ->join('hub_types', 'hubs.hub_type=hub_types.id', 'LEFT');   

            if (!empty($data['rand']))
            {
                return $tbh->orderBy('id', 'RANDOM')->get()->getRowArray();
            } 

            return $tbh->get()->getResultArray();
                // echo $this->getLastQuery(); 
        }
    }  

    public function remove(array $data = [])
    { 
        return $this->delete($data['id'], true);
    }
}
