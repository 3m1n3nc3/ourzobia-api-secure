<?php namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Database\ConnectionInterface;

class StatsModel extends Model
{ 
    protected $db;  

    public function get(array $data = [])
    {     
        $ap = $this->db->table('active_products');
        if (isset($data['uid'])) $ap->where('all_products.uid', $data['uid'])->join('all_products','all_products.id=active_products.product_id','LEFT');
        $active_products = $ap->select('COALESCE(COUNT(active_products.id), 0)')->where(['active_products.status' => '\'1\''], FALSE, FALSE)->getCompiledSelect();  
            
        $alp = $this->db->table('all_products');
        if (isset($data['uid'])) $alp->where('all_products.uid', $data['uid']);
        $all_products = $alp->select('COALESCE(COUNT(id), 0)')->where(['all_products.status' => '\'1\''], FALSE, FALSE)->getCompiledSelect();   
            
        $au  = $this->db->table('users');
        if (isset($data['uid'])) $au->where('users.uid', $data['uid']);
        $all_users  = $au->select('COALESCE(COUNT(uid), 0)')->getCompiledSelect();  

        $st = $this->db->table('all_products');
        if (isset($data['uid'])) $st->where('all_products.uid', $data['uid']);
        $stats = $st->select("($active_products) active_products, ($all_products) all_products, ($all_users) all_users")->get()->getRowArray(); 
        // echo $this->getLastQuery(); 
        return $stats;
    } 

    public function userscharts($week = null, $from = null, $to = null)
    {
        $users_t = $this->db->table('users'); 
        $counter = $users_t->select('count(`uid`)')->where('DATE(FROM_UNIXTIME(reg_time)) = dated', NULL, FALSE)->getCompiledSelect();

        $users_t->select("DATE(FROM_UNIXTIME(reg_time)) dated, ($counter) count");

        if (!empty($from) && !empty($to)) 
        {
            $users_t->where("DATE(FROM_UNIXTIME(reg_time)) >= DATE('{$from}') AND DATE(FROM_UNIXTIME(reg_time)) <= DATE('{$to}')");
        }
        elseif (is_numeric($week)) 
        {
            $users_t->where("WEEK(DATE(FROM_UNIXTIME(reg_time))) = WEEK(CURDATE())-{$week} AND YEAR( DATE(FROM_UNIXTIME(reg_time))) = YEAR(CURDATE())");
        } 
        elseif ($week === 'm') 
        {
            $users_t->where("MONTH(DATE(FROM_UNIXTIME(reg_time))) = MONTH(CURDATE()) AND YEAR(DATE(FROM_UNIXTIME(reg_time))) = YEAR(CURDATE())");
        }

        $stats = $users_t->groupBy('dated')->orderBy('DAY(dated)', 'ASC')->get()->getResultArray(); 

        return $stats;
    } 
} 
