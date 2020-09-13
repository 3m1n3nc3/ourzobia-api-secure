<?php namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Database\ConnectionInterface;

class StatsModel extends Model
{ 
    protected $db;  

    public function get(array $data = [])
    {     
        $active_products = $this->db->table('active_products')->select('COALESCE(COUNT(id), 0)')
            ->where(['active_products.status' => '\'1\''], FALSE, FALSE)->getCompiledSelect();  
            
        $all_products = $this->db->table('all_products')->select('COALESCE(COUNT(id), 0)')
            ->where(['all_products.status' => '\'1\''], FALSE, FALSE)->getCompiledSelect();   
            
        $all_users  = $this->db->table('users')->select('COALESCE(COUNT(uid), 0)')->getCompiledSelect();  

        $stats = $this->db->table('all_products') 
            ->select("($active_products) active_products, ($all_products) all_products, ($all_users) all_users")   
            ->get()->getRowArray(); 
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
