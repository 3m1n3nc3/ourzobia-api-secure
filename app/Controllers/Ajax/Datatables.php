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
        $users_t = $this->db->table('users');

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
            0=>'uid',
            1=>'fullname', 
            2=>'username', 
            3=>'email',
            4=>'status',
            5=>'reg_time'
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
            $users_t->orderBy($order, $dir);
        }
        
        if(!empty($search))
        {
            $x=0;
            foreach($valid_columns as $sterm)
            {
                if($x==0)
                {
                    $users_t->like($sterm,$search);
                }
                else
                {
                    $users_t->orLike($sterm,$search);
                }

                $x++;
            }                 
        }

        $users_t->limit($length,$start);   
        $content = $users_t->select('*')->get();
        $data = array();
        $i = 0;
        foreach($content->getResult() as $rows)
        { 
            $i++;

            $user = $this->account_data->fetch($rows->uid);   
 
            $data[]= array(
                $user['uid'],
                anchor($user['profile_link'], $user['fullname'],
                    ['id' => 'name'.$user['uid'], 'data-img' => $user['avatar_link'], 'data-uid' => $user['uid']]), 
                $user['username'],  
                $user['email'],  
                anchor_popup(site_url('admin/users/access/'.$user['uid']), '<i class="fa '.($user['status']>=2 ? 'fa-unlock text-success' : 'fa-lock text-danger') . ' mr-1"></i>') . 
                user_status(['status'=>$user['status'], 'admin'=>$user['admin']]),
                date('d M Y', $user['reg_time']) . '<br>' . date('h:i A', $user['reg_time']),
                (logged_user('admin')>=3 ?
                '<a href="'.site_url('user/account/admin/manage/'.$user['uid']).'" class="btn btn-success btn-sm btn-spinner font-weight-bold px-1 m-1" title="Manage User">
                    Manage
                </a>' : ''). 
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
        $users_t = $this->db->table('users');
        $query  = $users_t->select("COUNT(uid) as num")->get();
        $result = $query->getRow(); 
        if(isset($result)) return $result->num;
        return 0;
    } 

    /**
     * Get the cashout for prepaid products
     * @param  string   $id 
     * @return null     Does not return anything but echoes a JSON Object with the response
     */
    public function products($id = null)
    {
        $users_t = $this->db->table('all_products alp');
        $users_t->join('active_products acp', 'alp.id=acp.product_id', 'LEFT');

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
            $users_t->orderBy($order, $dir);
        }
        
        if(!empty($search))
        {
            $x=0;
            foreach($valid_columns as $sterm)
            {
                if($x==0)
                {
                    $users_t->like($sterm,$search);
                }
                else
                {
                    $users_t->orLike($sterm,$search);
                }

                $x++;
            }                 
        }

        $users_t->limit($length,$start);   
        $content = $users_t->select('alp.*, acp.status status')->get();
        $data = array();
        $i = 0;
        foreach($content->getResult() as $rows)
        { 
            $i++;

            $user = $this->account_data->fetch($rows->uid);   
 
            $data[]= array(
                $rows->id,
                $rows->name,
                product_status($rows->status) . $rows->code, 
                anchor($user['profile_link'], $user['fullname'],
                    ['id' => 'name'.$user['uid'], 'data-img' => $user['avatar_link'], 'data-uid' => $user['uid']]), 
                anchor(prep_url($rows->domain)),
                mailto($rows->email),  
                date('d M Y', $rows->date) . '<br>' . date('h:i A', $rows->date),
                (logged_user('admin')>=3 ?
                '<a href="'.site_url('admin/products/create/'.$rows->id).'" class="btn btn-success btn-sm btn-spinner font-weight-bold px-1 m-1" title="Edit Product">
                    Edit
                </a>' : ''). 
                '<button 
                    type="button" 
                    class="btn btn-danger btn-sm btn-spinner font-weight-bold px-1 m-1 cancel"  
                    data-type="products"
                    data-id="'.$rows->id.'"
                    data-toggle="tooltip" 
                    title="Delete Product"
                    onclick="cancel_(this, \'#tr_'.$rows->id.'\')">
                    <i class="fa fa-trash"></i>
                </button>',
                20 => 'tr_'.$rows->id
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
    public function total_products($id = null)
    {      
        $users_t = $this->db->table('users');
        $query  = $users_t->select("COUNT(uid) as num")->get();
        $result = $query->getRow(); 
        if(isset($result)) return $result->num;
        return 0;
    } 
}
