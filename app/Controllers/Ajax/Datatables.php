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
    public function total_users($id = null)
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
            if (!$uid) 
            { 
                $data[$keys][] = anchor($user['profile_link'], $user['fullname'],
                    ['id' => 'name'.$user['uid'], 'data-img' => $user['avatar_link'], 'data-uid' => $user['uid']]);
            }
            $data[$keys][] = ($rows->domain) ? anchor(prep_url($rows->domain)) : '';
            $data[$keys][] = mailto($rows->email);
            $data[$keys][] = date('d M Y', $rows->date) . '<br>' . date('h:i A', $rows->date);

            if (!$uid) 
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
     * Get count of the inventory
     * @param  string   $uid 
     * @return Object 
     */
    public function total_products($uid = null)
    {      
        $set_table = $this->db->table('all_products');
        $query  = $set_table->select("COUNT(uid) as num")->get();
        if ($uid) 
        {
            $set_table->where('uid', $uid);   
        }
        $result = $query->getRow(); 
        if(isset($result)) return $result->num;
        return 0;
    } 
}
