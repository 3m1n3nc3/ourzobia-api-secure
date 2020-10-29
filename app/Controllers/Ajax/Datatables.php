<?php namespace App\Controllers\Ajax;

use App\Controllers\BaseController; 

/**
 * Sends response with data records to jquery datatable
 */ 
class Datatables extends BaseController 
{
    public function __construct()
    {   
        $this->request = \Config\Services::request();
        $this->request->setHeader('Content-Type', 'application/json'); 
        $this->db = \Config\Database::connect();
    }
    
    public function index()
    { 
        $data = [];//$this->db->table('users')->get()->getResult(); 
        return $this->response->setJSON($data);
    } 
    

    /**
     * Get the cashout for prepaid users
     * @param  string   $id 
     * @return null     Does not return anything but echoes a JSON Object with the response
     */
    public function users($id = null)
    {
        $set_table = $this->db->table('users');

        $draw   = intval($this->request->getPost("draw"));
        $start  = intval($this->request->getPost("start"));
        $length = intval($this->request->getPost("length"));
        $order  = $this->request->getPost("order");
        $search = $this->request->getPost("search");
        $search = $search['value'];
        $col    = 0;
        $dir    = "";
        if(!empty($order))
        {
            foreach($order as $o)
            {
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }

        if($dir != "asc" && $dir != "desc")
        {
            $dir = "desc";
        }

        $valid_columns = array(
            1=>'uid',
            2=>'fullname', 
            3=>'username', 
            4=>'email',
            5=>'status',
            6=>'reg_time'
        );

        if(!isset($valid_columns[$col]))
        {
            $order = null;
        }
        else
        {
            $order = $valid_columns[$col];
        }

        if($order !=null)
        {
            $set_table->orderBy($order, $dir);
        }
        
        if(!empty($search))
        {
            $x=0;
            foreach($valid_columns as $sterm)
            {
                if($x==0)
                {
                    $set_table->like($sterm,$search);
                }
                else
                {
                    $set_table->orLike($sterm,$search);
                }

                $x++;
            }                 
        }

        $set_table->limit($length,$start);   
        $content = $set_table->select('*')->get();
        $data = array();
        $i = 0;
        foreach($content->getResult() as $key => $rows)
        { 
            $i++;

            $user = $this->account_data->fetch($rows->uid);   
 
            $data[]= array(
                '<div class="icheck-primary">
                    <input type="checkbox" id="check'.$key.'" class="checkboxes" data-uid="'.$rows->uid.'">
                    <label for="check'.$key.'"></label>
                </div>',
                $user['uid'],
                anchor($user['profile_link'], $user['fullname'],
                    ['id' => 'name'.$user['uid'], 'data-img' => $user['avatar_link'], 'data-uid' => $user['uid']]), 
                $user['username'],  
                mailto($user['email']) . ($user['cpanel'] ? 
                    '<br><i class="fab fa-cpanel fa-lg text-danger" title="'.$user['username'] . '@' . my_config('cpanel_domain').'"></i>' : ''
                ),  
                anchor_popup(site_url('admin/users/access/'.$user['uid']), '<i class="fa '.($user['status']>=2 ? 'fa-unlock text-success' : 'fa-lock text-danger') . ' mr-1"></i>') . 
                user_status(['status'=>$user['status'], 'admin'=>$user['admin']]),
                date('d M Y', $user['reg_time']) . '<br>' . date('h:i A', $user['reg_time']),
                (logged_user('admin')>=3 ? 
                    anchor('user/account/settings/' . $user['uid'], 'Manage', ['class'=>'btn btn-success btn-sm btn-spinner font-weight-bold px-1 m-1', 'title'=>'Manage User']) : ''
                ) .  
                '<button 
                    type="button" 
                    class="btn btn-danger btn-sm btn-spinner font-weight-bold px-1 m-1 cancel"  
                    data-type="users"
                    data-id="'.$user['uid'].'"
                    data-toggle="tooltip" 
                    title="Delete User"
                    onclick="cancel_(this, \'#tr_'.$user['uid'].'\')">
                    <i class="fa fa-trash"></i>
                </button>',
                20 => 'tr_'.$user['uid']
            );   
        }   
        $total_prepaid = $this->total_users($id);
        $output = array(
            "draw" => $draw,
            "recordsTotal" => $total_prepaid,
            "recordsFiltered" => $total_prepaid,
            "data" => $data
        );

        // Check for AJAX request.
        if ($this->request->isAJAX())
        { 
            return $this->response->setJSON($output);
        }
    }
    

    /**
     * Get count of the inventory
     * @param  string   $id 
     * @return Object 
     */
    private function total_users($id = null)
    {      
        $set_table = $this->db->table('users');
        $query  = $set_table->select("COUNT(uid) as num")->get();
        $result = $query->getRow(); 
        if(isset($result)) return $result->num;
        return 0;
    } 

    /**
     * Get the cashout for prepaid products
     * @param  string   $id 
     * @return null     Does not return anything but echoes a JSON Object with the response
     */
    public function products($uid = null)
    {
        $set_table = $this->db->table('all_products alp');
        $set_table->join('active_products acp', 'alp.id=acp.product_id', 'LEFT');

        $draw   = intval($this->request->getPost("draw"));
        $start  = intval($this->request->getPost("start"));
        $length = intval($this->request->getPost("length"));
        $order  = $this->request->getPost("order");
        $search = $this->request->getPost("search");
        $search = $search['value'];
        $col    = 0;
        $dir    = "";
        if(!empty($order))
        {
            foreach($order as $o)
            {
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }

        if($dir != "asc" && $dir != "desc")
        {
            $dir = "desc";
        }

        $valid_columns = array(
            0=>'id',
            1=>'name', 
            2=>'email', 
            3=>'uid', 
            4=>'domain',
            5=>'email', 
            6=>'date'
        );

        if(!isset($valid_columns[$col]))
        {
            $order = null;
        }
        else
        {
            $order = $valid_columns[$col];
        }

        if($order !=null)
        {
            $set_table->orderBy($order, $dir);
        }
        
        if(!empty($search))
        {
            $x=0;
            foreach($valid_columns as $sterm)
            {
                if($x==0)
                {
                    $set_table->like($sterm,$search);
                }
                else
                {
                    $set_table->orLike($sterm,$search);
                }

                $x++;
            }                 
        }

        if ($uid) 
        {
            $set_table->where('alp.uid',$uid);   
        }

        $set_table->limit($length,$start);   
        $content = $set_table->select('alp.*, acp.status status')->get();
        $data = array();
        $i = 0;
 
        foreach($content->getResult() as $keys => $rows)
        { 
            $i++;

            $user = $this->account_data->fetch($rows->uid);   
 
            $data[$keys][] = $rows->id;
            
            $data[$keys][] = $rows->name;
            $data[$keys][] = product_status($rows->status) . $rows->code;
            if (!$uid && logged_user("admin")) 
            { 
                $data[$keys][] = anchor($user['profile_link'], $user['fullname'],
                    ['id' => 'name'.$user['uid'], 'data-img' => $user['avatar_link'], 'data-uid' => $user['uid']]);
            }
            $data[$keys][] = ($rows->domain) ? anchor(prep_url($rows->domain)) : '';
            $data[$keys][] = mailto($rows->email);
            $data[$keys][] = date('d M Y', $rows->date) . '<br>' . date('h:i A', $rows->date);

            if (!$uid && logged_user("admin")) 
            { 
                $data[$keys][] = '
                    <a href="'.site_url('admin/products/create/'.$rows->id).'" class="btn btn-success btn-sm btn-spinner font-weight-bold px-1 m-1" title="Edit Product">
                        Edit
                    </a>
                    <button 
                        type="button" 
                        class="btn btn-danger btn-sm btn-spinner font-weight-bold px-1 m-1 cancel"  
                        data-type="products"
                        data-id="'.$rows->id.'"
                        data-toggle="tooltip" 
                        title="Delete Product"
                        onclick="cancel_(this, \'#tr_'.$rows->id.'\')">
                        <i class="fa fa-trash"></i>
                    </button>';
                $data[$keys][20] = 'tr_'.$rows->id;
            }   
        }   

        $total_prepaid = $this->total_products($uid);
        $output = array(
            "draw" => $draw,
            "recordsTotal" => $total_prepaid,
            "recordsFiltered" => $total_prepaid,
            "data" => $data
        );

        // Check for AJAX request.
        if ($this->request->isAJAX())
        { 
            return $this->response->setJSON($output);
        }
    }
    

    /**
     * Get count of the products
     * @param  string   $uid 
     * @return Object 
     */
    private function total_products($uid = null)
    {       
        $set_table = $this->db->table('all_products'); 
        $query = $set_table->select("COUNT(uid) as num")->get();
        if ($uid) 
        {
            $set_table->where('uid', $uid);   
        }
        $result = $query->getRow(); 
        if(isset($result)) return $result->num;
        return 0;
    } 

    /**
     * Get the cashout for prepaid products
     * @param  string   $id 
     * @return null     Does not return anything but echoes a JSON Object with the response
     */
    public function payments($uid = null)
    {
        $set_table = $this->db->table('payments'); 

        $draw   = intval($this->request->getPost("draw"));
        $start  = intval($this->request->getPost("start"));
        $length = intval($this->request->getPost("length"));
        $order  = $this->request->getPost("order");
        $search = $this->request->getPost("search");
        $search = $search['value'];
        $col    = 0;
        $dir    = "";
        if(!empty($order))
        {
            foreach($order as $o)
            {
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }

        if($dir != "asc" && $dir != "desc")
        {
            $dir = "desc";
        }

        if ($uid && logged_user("admin")) 
        {
            $valid_columns = array(
                0=>'id',
                1=>'uid',
                2=>'method',
                3=>'amount' , 
                4=>'reference', 
                5=>'description',  
                6=>'date'
            );
        }  
        else
        {
            $valid_columns = array(
                0=>'id',
                1=>'amount' , 
                2=>'reference', 
                3=>'description',  
                4=>'date'
            );
        }

        if(!isset($valid_columns[$col]))
        {
            $order = null;
        }
        else
        {
            $order = $valid_columns[$col];
        }

        if($order !=null)
        {
            $set_table->orderBy($order, $dir);
        }
        
        if(!empty($search))
        {
            $x=0;
            foreach($valid_columns as $sterm)
            {
                if($x==0)
                {
                    $set_table->like($sterm,$search);
                }
                else
                {
                    $set_table->orLike($sterm,$search);
                }

                $x++;
            }                 
        }

        if ($uid) 
        {
            $set_table->where('payments.uid',$uid);   
        }

        $set_table->limit($length,$start);   
        $content = $set_table->select('*')->get();
        $data = array();
        $i = 0;
 
        foreach($content->getResult() as $keys => $rows)
        { 
            $i++;

            $user = $this->account_data->fetch($rows->uid);   
 
            $currency_method = (!empty($rows->method) && !in_array($rows->method, ['paystack'])) ? ($rows->method.'_currency') : 'site_currency';

            $data[$keys][] = $rows->id;   
            if (!$uid && logged_user("admin")) 
            { 
                $data[$keys][] = anchor($user['profile_link'], $user['fullname'],
                    ['id' => 'name'.$user['uid'], 'data-img' => $user['avatar_link'], 'data-uid' => $user['uid']]);
                $data[$keys][] = ucwords($rows->method??"N/A");  
            } 
            $data[$keys][] = money($rows->amount,null,my_config($currency_method, NULL, "USD"));   
            $data[$keys][] = $rows->reference;    
            $data[$keys][] = $rows->description;    
            $data[$keys][] = date('d M Y - h:i A', $rows->date);  
        }   

        $total_prepaid = $this->total_payments($uid);
        $output = array(
            "draw" => $draw,
            "recordsTotal" => $total_prepaid,
            "recordsFiltered" => $total_prepaid,
            "data" => $data
        );

        // Check for AJAX request.
        if ($this->request->isAJAX())
        { 
            return $this->response->setJSON($output);
        }
    }
    

    /**
     * Get count of the products
     * @param  string   $uid 
     * @return Object 
     */
    private function total_payments($uid = null)
    {       
        $set_table = $this->db->table('payments'); 
        $query = $set_table->select("COUNT(id) as num")->get();
        if ($uid) 
        {
            $set_table->where('uid', $uid);   
        }
        $result = $query->getRow(); 
        if(isset($result)) return $result->num;
        return 0;
    } 

    /**
     * Get the cashout for prepaid products
     * @param  string   $id 
     * @return null     Does not return anything but echoes a JSON Object with the response
     */
    public function analytics($uid = null)
    {
        helper("html");

        $set_table = $this->db->table('analytics'); 

        $draw   = intval($this->request->getPost("draw"));
        $start  = intval($this->request->getPost("start"));
        $length = intval($this->request->getPost("length"));
        $order  = $this->request->getPost("order");
        $search = $this->request->getPost("search");
        $search = $search['value'];
        $col    = 0;
        $dir    = "";
        if(!empty($order))
        {
            foreach($order as $o)
            {
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }

        if($dir != "asc" && $dir != "desc")
        {
            $dir = "desc";
        }

        $valid_columns = array(
            0=>'date',
            1=>'uip',
            2=>'type',
            3=>'metric' , 
            4=>'referrer', 
            5=>'uid',  
            6=>'item_id',  
            7=>'date'
        ); 

        if(!isset($valid_columns[$col]))
        {
            $order = null;
        }
        else
        {
            $order = $valid_columns[$col];
            $dir = $col == 0 ? 'desc' : $dir;
        }

        if($order !=null)
        {
            $set_table->orderBy($order, $dir);
        }
        else
        { 
            $set_table->orderBy('date', 'desc');
        }
        
        if(!empty($search))
        {
            $x=0;
            foreach($valid_columns as $sterm)
            {
                if($x==0)
                {
                    $set_table->like($sterm,$search);
                }
                else
                {
                    $set_table->orLike($sterm,$search);
                }

                $x++;
            }                 
        }

        if ($uid) 
        {
            $set_table->where('analytics.uid',$uid);   
        }

        $set_table->limit($length,$start);   
        $content = $set_table->select('*')->get();
        $data = array();
        $i = 0;
 
        foreach($content->getResult() as $keys => $rows)
        { 
            $i++;

            $user = $this->account_data->fetch($rows->uid);

            if (in_array($rows->metric, ['activations', 'validations']) && $rows->item_id) 
            {
                $item = $this->products_m->getWhere(['id' => $rows->item_id], 1)->getRowArray();
                $rows->item_id = anchor("admin/products/create/{$item['id']}", nl2br("{$item['name']} \n {$item['domain']}"));
            }

            if ($rows->ip_info) 
            {
                $ip_info = toArray(json_decode($rows->ip_info, JSON_FORCE_OBJECT)); 
                $rows->ip_info = $rows->uip??"N/A";
                $rows->ip_info .= "\n" . img($ip_info["location"]["country_flag"]??"", false, ['alt'=>($ip_info["country_name"]??''), 'height'=>'11px']) . " " . ($ip_info["city"]??'') . ", " . ($ip_info["country_name"]??''); 
            }

            $data[$keys][] = $i;    
            $data[$keys][] = nl2br($rows->ip_info??$rows->uip);      
            $data[$keys][] = $rows->type??"N/A";   
            $data[$keys][] = $rows->metric??"N/A";   
            $data[$keys][] = $rows->referrer??"N/A";    
            $data[$keys][] = $user ? anchor($user['profile_link'], $user['fullname'],
                    ['id' => 'name'.$user['uid'], 'data-img' => $user['avatar_link'], 'data-uid' => $user['uid']]) : "N/A";
            $data[$keys][] = (!is_numeric($rows->item_id)) ? $rows->item_id : "N/A";    
            $data[$keys][] = date('d M Y - h:i A', $rows->date);  
        }   

        $total_prepaid = $this->total_analytics($uid);
        $output = array(
            "draw" => $draw,
            "recordsTotal" => $total_prepaid,
            "recordsFiltered" => $total_prepaid,
            "data" => $data
        );

        // Check for AJAX request.
        if ($this->request->isAJAX())
        { 
            return $this->response->setJSON($output);
        }
    }
    

    /**
     * Get count of the products
     * @param  string   $uid 
     * @return Object 
     */
    private function total_analytics($uid = null)
    {       
        $set_table = $this->db->table('analytics'); 
        $query = $set_table->select("COUNT(id) as num")->get();
        if ($uid) 
        {
            $set_table->where('uid', $uid);   
        }
        $result = $query->getRow(); 
        if(isset($result)) return $result->num;
        return 0;
    } 
}
