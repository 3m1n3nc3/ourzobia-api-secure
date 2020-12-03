<?php namespace App\Models;

use CodeIgniter\Model;
use \App\Libraries\Creative_lib;

class PostsModel extends Model
{ 
    protected $db;
    protected $table      = 'posts';
    protected $primaryKey = 'post_id';

    protected $perpage    = 10;
    protected $perpost    = 10;

    protected $returnType = 'array';
    protected $useSoftDeletes = true;
 
    protected $allowedFields = ['token', 'uid', 'title' ,'description', 'tags', 'link', 'file', 'thumbnail', 'youtube', 'meta', 'event_time', 'event_venue', 'time', 
    'type', 'featured'];

	protected $useTimestamps = true;
	protected $dateFormat    = 'int';
    protected $createdField  = 'time';
    protected $updatedField  = 'updated';
    protected $deletedField  = 'deleted'; 

    public function create($data = array())
    {
        if (!empty($data['getId']))
        {
            $data['token'] = $data['token'] ?? MD5(time());
            $this->insert($data);
            return $this->insertID();
        }
        return $this->save($data);
    }

    public function get_post($data = array())
    {
        $perpage = (my_config('perpage')) ? my_config('perpage') : $this->perpage;

        if (isset($data['type'])) 
        {
            $this->where('type', $data['type']);
        }

        if (!empty($data['post_id'])) 
        {
            $this->groupStart()
                ->where('post_id', $data['post_id'])
                ->orWhere('token', $data['post_id'])
            ->groupEnd();
            return $this->first();
        } 

        if (!empty($data['uid'])) 
        {
            $this->where('uid', $data['uid']);
        } 

        if (!empty($data['featured'])) 
        {
            $this->where('featured', 1);
        } 

        if (empty($data['order'])) 
        {
            $this->orderBy('featured', 'DESC');
            $this->orderBy('time', 'DESC');
        } 

        if (empty($data['post_id'])) 
        {
            return $this->paginate($perpage);
        } 

        return $this->find($data['post_id']);
    }   

    public function blog_posts($data = array())
    {
        $this->where('event_time', NULL);
        return $this->get_post($data); 
    } 

    public function event_posts($data = array())
    {
        $this->where('event_time !=', NULL);
        return $this->get_post($data); 
    }

    public function get_last($uid = null)
    {  
        $this->select('*')->where('uid', user_id($uid)); 

        return $this->orderBy('time', 'DESC')->limit(1)->first();
    }  

    public function get_likers($id, $limit = null, $offset = 0)
    {
        $likes = $this->db->table('likes');
        $likes->where('item_id', $id)->select('users.username, users.uid')->join('users', 'users.uid  = likes.uid');
        if ($limit) 
        {
            $likes->limit($limit, $offset);
        }
        return $likes->get()->getResultArray();
    }

    public function count_likes($id, $type = 'posts')
    {
        $likes = $this->db->table('likes');
        $likes->where('item_id', $id)->where('type', $type);
        return $likes->countAllResults();
    }

    public function like($data)
    {
        $likes = $this->db->table('likes');
        if (liked($data['item_id'], $data['type']))
        {
            $likes->where(['type' =>$data['type'], 'item_id' => $data['item_id']]);
            if ($likes->delete())
                return true;
        }

        if ($likes->insert($data));
            return true;
    } 

    public function count_comments($id, $type = 'comment')
    {
        $comments = $this->db->table('comments'); 
        $comments->where('post_id', $id)->where('type', $type);
        return $comments->countAllResults();
    }

    public function get_comments($post_id, $type = 'comment', $page = 1, $inline = false)
    {
        if ($inline) 
        {
            $perpost = my_config('inline_comments', null, 10);
        }
        else
        {
            $perpost = (my_config('perpage')) ? my_config('perpost') : $this->perpost;
        }

        $perpost  = (int)$perpost;
        $comments = $this->db->table('comments');

        if (is_array($post_id))
        {
            if (!empty($post_id['id'])) 
            {
                $comments->where(['id' => $post_id['id']]);
            }
            return $comments->get()->getRowArray();
        }

        $col = ($type === 'reply') ? 'reply_id' : ($type === 'comment' ? 'post_id' : 'post_id');
        $comments->where([$col => $post_id, 'type' => $type]);
        // $comments->join('users', 'users.uid  = comments.uid');
 
        $offset      = ($page - 1) * $perpost;

        if (is_bool($inline)) 
        {
            $comments->limit($perpost, $offset);
        }

        return $comments->get()->getResultArray();
        // echo $this->getLastQuery(); 
    }

    public function comment($data)
    {
        $comments = $this->db->table('comments');

        if (!empty($data['id']))
        {
            $comments->update($data);
            return $data['id'];
        }
        
        $comments->insert($data);
        return $this->insertID();
    }  

    public function cancel(array $data = [])
    { 
        // Delete only comment
        if (!empty($data['data'])) 
        {
            if (in_array($data['data']['type'], ['comment', 'reply'])) 
            {  
                if ($this->db->table('comments')->where(['id' => $data['id']])->delete())
                {
                    // Delete comment replies
                    if ($data['data']['type'] === 'comment')
                    {  
                        $this->db->table('comments')->where(['reply_id' => $data['id']])->delete();
                    }
                    return ['msg' => 'Comment Deleted'];
                }
            }
            elseif (in_array($data['data']['type'], ['notification'])) 
            {
                // Delete notifications
                if ($this->db->table('notifications')->where(['id' => $data['id']])->delete()) 
                    return ['msg' => 'Notification Deleted']; 
            }
            return;
        }

        // Delete posts
        $creative = new Creative_lib;
        $post     = $this->find($data['id']);

        if (!empty($post))
        { 
            if (!empty($post['file']) || !empty($post['thumbnail'])) 
            {
                $creative->delete_file('./' . $post['file']);
            }

            if (!empty($post['thumbnail'])) 
            {
                $creative->delete_file('./' . $post['thumbnail']);
            } 

            if (!empty($post['meta'])) 
            {
                $meta = toArray(json_decode($post['meta']));
                if (!empty($meta['file'])) 
                {
                    $creative->delete_file('./' . $meta['file']);
                }
            } 

            $comments = $this->db->table('comments');
            // $likes    = $this->db->table('likes');

            $comments->where(['post_id' => $data['id']]);
            if ($comments->delete()) 
            {
                // At a later time, you may implement this
                // $likes->where(['type' => 'comments', 'item_id' => $data['id']]);
                // $likes->delete();
            }

            // $likes->where(['type' => 'posts', 'item_id' => $data['id']]);
            // $likes->delete();

            if ($this->delete($data['id'], true))
                return ['msg' => 'Post Deleted'];
        }
    }
}
