<?php namespace App\Libraries; 

use App\Libraries\Notifications;
use \App\Libraries\Account_Data;

/**
 * Utility methods.
 */
class Util
{    

    /**
     * SendMail.
     *
     * This method will provide default configuration for SMTP mailing 
     *
     * @param$login     A numeric array of login username and password
     * $login param list array{
     *      username?:string,
     *      password?:string
     *      hostname?:string
     *      hostport?:string
     * }
     */
    public function email_config($login = []) 
    {  
        $smtp_user   = $login['username'] ?? my_config('smtp_user');
        $smtp_pass   = $login['password'] ?? my_config('smtp_pass');
        $smtp_host   = $login['hostname'] ?? my_config('smtp_host');
        $smtp_port   = $login['hostport'] ?? my_config('smtp_port'); 
        $smtp_crypto = empty($login['username']) ? my_config('smtp_crypto') : ($login['crypto'] ?? 'tls');
        $protocol    = empty($login['username']) ? my_config('email_protocol') : (localhosted() ? 'smtp' : 'SMTP');

        $config = array(
            'userAgent'  => my_config('site_name') . ' Mail Daemon',
            'mailPath'   => my_config('mailpath'),
            'protocol'   => $protocol,
            'SMTPCrypto' => $smtp_crypto,
            'SMTPHost'   => $smtp_host,
            'SMTPPort'   => $smtp_port,
            'SMTPUser'   => $smtp_user,
            'SMTPPass'   => $smtp_pass,
            'charset'    => 'utf-8',
            'newline'    => "\r\n",
            'crlf'       => "\r\n",
            'mailType'   => 'html',
            'wordWrap'   => true
        );

        return $config;
    }

    
    public static function email_config_static($login = []) 
    {  
        $util = new \App\Libraries\Util;
        return $util->email_config($login);
    }

    
    public static function parse_content($content, $data = []) 
    {    
        $content = preg_replace_callback('/{\$lang=(.+?)}/i', function($matches) use ($data)
        { 
            return _lang(''.$matches[1]);
        },  $content);

        $content = preg_replace_callback('/{\$conf=(.+?)}/i', function($matches) use ($data)
        { 
            $creative = new \App\Libraries\Creative_lib;
            
            if ($matches[1] == 'site_url') 
            {
                return site_url();
            }

            if ($matches[1] == 'logo') 
            {
                return $creative->fetch_image(my_config('site_logo'), 'badge');
            }
            return my_config($matches[1]);
        },  $content);

        $content = preg_replace_callback('/{\$([a-zA-Z0-9_]+)}/', function($matches) use ($data)
        {   
            return (isset($data[$matches[1]])?$data[$matches[1]]:"");
        },  $content);

        return showBBcodes($content);
    }

    /**
     * SendMail.
     *
     * This method will parse the provided content and attempt to send an email
     * message to the provided recipient.
     *
     *@param $content   Array   has to hold the following data:
     *     subject    = A string representing the subject of the email message
     *     message    = A string representing the message body of the email message
     *     link       = A string representing a link to send along with the email message
     *     link_t     = A string representing the title of the link to send along with the email message
     *     attachment = [optional] Can be local path, URL or buffered content
     *     receiver   = An associative array containing the data of the the recipient of the email message
     *         receiver array must contain [email, fullname]
     *     sender     = [optional] An associative array containing the data of the the sender of the email message
     *         sender array must contain [email, fullname]
     *     success    = A string to return as the status notification to user after sending message
     *@param $mailer_login  Array   
     * $mailer_login param list array{
     *      username?:string,
     *      password?:string
     *      hostname?:string
     *      port?:string
     * }
     */
    public static function sendMail(array $content = [], $mailer_login = []): array
    {
        // Set default responses
        $data['success'] = false;
        $data['status']  = 'error';  
        $data['message'] = $content['success'] ?? "";

        // Generate the message content 
        $message  = $content['message'] ?? "";
        $subject  = $content['subject'] ?? "";
        $link     = $content['link'] ?? null;
        $link_t   = $content['link_t'] ?? null;
        $receiver = $content['receiver'] ?? logged_user();
        $sender   = $content['sender'] ?? [];

        // Parse the message content
        $anchor_link  = $link ? anchor($link) : $link;
        $message_html = self::parse_content(my_config('email_template'), [
            'message' => self::parse_content($message, [ 
                'title'   => $subject, 
                'user'    => $receiver['fullname'],  
                'anchor_link' => $anchor_link, 
                'link'        => $link ? site_url($link) : $link, 
                'link_title'  => $link_t
            ]), 
            'title'   => $subject,
            'user'    => $receiver['fullname'],
            'anchor_link' => $anchor_link,
            'link'        => $link ? site_url($link) : $link,
            'link_title'  => $link_t
        ]);

        // Attempt to send the mail with Mailjet
        $use_mailjet = (my_config('mailjet_api_key') && my_config('mailjet_secret_key') && my_config('email_protocol') == 'mailjet' && empty($sender['email']));

        if ($use_mailjet)
        {
            try 
            {
                $email = \Config\Services::mailjet(my_config('mailjet_api_key'), my_config('mailjet_secret_key'));
                $send  = $email->post(\Mailjet\Resources::$Email, ['body' => [
                    'Messages' => [
                        [
                            'From' => [ 'Email' => my_config('contact_email'), 'Name' => my_config('site_name') ],
                            'To' => [
                                [ 'Email' => $receiver['email'], 'Name' => $receiver['fullname'] ]
                            ],
                            'Subject' => $subject,
                            'TextPart' => $message,
                            'HTMLPart' => $message_html
                        ]
                    ]
                ]]);
                if (my_config('mail_debug')) 
                { 
                    $data['message'] = "<pre>".json_encode($send->getData(), JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES)."</pre>";
                }

                $data['success'] = true;
                $data['status']  = 'success';  
            } 
            catch (\GuzzleHttp\Exception\ConnectException $e) 
            {
                $data['message'] = "Error: " . $e->getHandlerContext()['error'];
            }
        } 
        // Attempt to send the mail with \Config\Services::email()
        else
        {
            $email = \Config\Services::email(); 
            $email->initialize(self::email_config_static($mailer_login));
            $email->setFrom($sender['email'] ?? my_config('contact_email'), $sender['fullname'] ?? my_config('site_name'));
            $email->setTo($receiver['email']);

            if (!empty($content['attachment'])) 
            {
                $email->attach($content['attachment']);
            }

            if (!empty($sender['email'])) 
            {
                $message_html = $content['message'];
            } 

            $email->setSubject($subject);
            $email->setMessage($message_html);

            try { 
                if ($email->send(my_config('mail_debug') ? false : true)) 
                {
                    if (my_config('mail_debug')) 
                    {
                        $data['message'] = $email->printDebugger(['headers', 'subject']);
                    }
                    else
                    {
                        $data['success'] = true;
                        $data['status']  = 'success';    
                    }
                }
            } 
            catch (ErrorException $e) {
                $data['message'] = $e;
            }
        }

        return $data;
    }

    /**
     * @return float|int|string
     */
    public static function percent(float $a, float $b, bool $over = false, bool $asString = false, bool $fixedWidth = false)
    {
        if ($asString && $b == 0) {
            return '';
        }

        $percent = 100;

        if ($b > 0) {
            $percent = ($a / $b) * 100;
        }

        if ($b > 0 && $over == 'inv') {
            $percent = ($a * $b) / 100;
        }

        if ($over == false && $percent > 100) {
            $percent = 100;
        }

        if ($asString) {
            $format = $fixedWidth ? '%6.2F%%' : '%01.2F%%';

            return \sprintf($format, $percent);
        }

        return $percent;
    }

    /**
     * @return float|int|string
     */
    public static function completion($current = 100, $login_count = 30, array $package = [])
    {  
        $daily_percent = my_config('total_daily_percent');
        $duration      = 0;
        $units         = '';

        if (!empty($package['duration']) && !empty($package['units'])) 
        {
            $duration = $package['duration'];
            $units    = $package['units'];
        } 

        if ($daily_percent > 0 && $units == 'days') 
        {  
            $subtract       = (100-$daily_percent); 

            $login_progress = $percent = ($login_count / $duration) * 100;
            $login_progress = $login_progress-$subtract;
            if ($login_progress <= 0) 
            {
                $login_progress = 0; 
            }

            $current_progress = ($current-$daily_percent);
            if ($current_progress <= 0) 
            {
                $current_progress = 0; 
            }

            $true_progress = number_format(($login_progress + $current_progress),2);
        }
        else
        {
            $true_progress = $current;
        }
        return $true_progress;
    }  

    public static function loggedInIsAJAX($admin = false)
    {   
        $request  = \Config\Services::request();
        $response = \Config\Services::response();

        if (!$request->isAJAX() && (!user_id() || empty($admin['guest'])))
        { 
            $code = 400;
            $msg  = 'The request was not understood!';

            if (!$request->isAJAX())
            {
                $msg  = 'Resource not available for this request!';
            }

            if (!user_id() && empty($admin['guest'])) 
            {
                $code = 401; 
                $msg  = 'You are currently not logged in, please login to continue!'; 
            }

            if (is_array($admin) && !empty($admin['uid']) && $admin['uid'] !== user_id()) 
            {
                $code = 401; 
                $msg  = 'You do not have permission to access this resource!';
            }

            if ($admin === true && !logged_user('admin')) 
            {
                $code = 401; 
                $msg  = 'You do not have permission to access this resource!'; 
            }

            $response->setStatusCode($code);
            return $response->setJSON(['message'=>$msg, 'status' => 'error', 'success' => false]); 
        }
        return true;
    }     

    public function set_form($type='report_form', $btn_class='btn-success', $title = false, $action = '', $input = [])
    {
        $this->btn_class     = $btn_class ?? NULL;
        if (stripos($btn_class, '!') !== false)
        {
            $this->btn_class = str_ireplace('!', '', $btn_class);
            $this->alt_btn   = $this->btn_class;
        }
        $this->type        = $type ?? NULL;
        $this->title       = ($title) ? $title : ucwords(str_ireplace('_', ' ', $type));
        $this->form_action = $action ?? NULL;
        $this->input       = $input ?? NULL;
        return $this;
    }

    public function quickForm($item_id='',$type='payment_decline',$disabled=false,$show_input=false)
    {
        helper('form');
        $form_type = (!empty($this->type)) ? $this->type : 'report_form';
        $form_data = 'data-' . str_ireplace('_', '-', $form_type);

        // Set the type of the form
        $type   = ($type) ? $type : 'payment_decline';

        // Set the form title
        $title  = ucwords(str_ireplace('_', ' ', $type));
        $title  = ($disabled) ? _lang('reported') : _lang('report', [$title]);
        $title  = (!empty($this->title)) ? $this->title : $title;

        // Set the submit button class
        $btn_class  = (!empty($this->btn_class)) ? $this->btn_class :'btn-danger';

        // Set the button state to disabled
        $state  = ($disabled) ? ['disabled'=>'disabled'] : [];
        $_state = ($disabled) ? 'disabled="disabled" ' : '';

        // Generate the form
        $form  = "\n";
        $form .= form_open((!empty($this->form_action)) ? $this->form_action : '', 
            ['class' => $form_type, $form_data => $item_id, 'id' => 'rf'.$item_id]);

        // If $this->input is not set use the default
        if (empty($this->input)) 
        {
            $form .= form_hidden('type', $type);
        }
        elseif (!empty($this->input) && is_array($this->input)) 
        {
            // If $this->input['type'] is not set append the default type
            if (empty($this->input['type'])) 
            {
                $form .= form_hidden('type', $type);
            }
            // Loop through the inputs
            foreach ($this->input as $key => $item_id) 
            {
                $form .= form_hidden($key, $item_id);
            }
        }
        // If the form is not disabled and $show_input param is set show the details input
        if ($show_input && !$disabled) 
        {   
            $form .= form_label(_lang("$show_input"), "rfd_$item_id", ['class'=>'font-weight-bold']);
            $form .= form_textarea(
                ['name'=>$show_input, 'rows'=>'2'], '', $_state.'class="form-control mb-1" id="rfd_'.$item_id.'"');
        }
        
        $title = strtolower($title);
        $form .= form_button([
            'type' => 'submit', 'id' => 'rf_'.$item_id, 
            'class' => (!empty($this->alt_btn)) ? $this->alt_btn : 'btn-block btn ' . $btn_class . ' font-weight-bold mb-2',
            'onclick' => "confirmAction('submit', '#rf$item_id', 'submit', 'Do you want to continue $title?', this);"
        ], ucwords($title), $state);

        $form .= form_close();
        $form .= "\n";

        return $form;
    }

    public function save_analysis($metric = 'views', $pid = null, $ref = NULL)
    {  

        $analyticsModel = model('App\Models\AnalyticsModel', false);
        $request = \Config\Services::request();
        $agent   = $request->getUserAgent();

        if ($pid) 
        {
            $data['item_id'] = $pid;
            $analyticsModel->t_product();
        }
        else
        {
            $analyticsModel->t_site();
        }

        if ($agent->isReferral() && empty($ref)) 
        {
            $data['referrer'] = $agent->getReferrer(); 
        }
        else
        {
            $data['referrer'] = $ref; 
        }

        $data['uid']  = user_id(); 
        $data['date'] = time();
        $data['uip']  = $request->getIPAddress();
        if (!user_id()) 
        {
            $data['uid'] = 0;
        }

        $analyticsModel->metric($metric)->add($data);
    } 

    public static function ordinal($number) {
        $ends = array('th','st','nd','rd','th','th','th','th','th','th');
        if ((($number % 100) >= 11) && (($number%100) <= 13))
            return $number. 'th';
        else
            return $number. $ends[$number % 10];
    } 

    /**
     * @param string    $week    
     */
    public function statsConf($week = null, $chart = 'users', $metric = 'visit')
    {
        $this->chart = $chart;
        $this->week  = $week;
        $this->metric  = $metric;
        return $this;
    }

    public function statsCharts()
    {
        $this->chart = (!empty($this->chart) ? $this->chart : 'users');
        $chart = $this->chart . 'charts';
        $week  = $this->week??null; 

        $request = \Config\Services::request();
        $from = $to = null;
        if ($range = $request->getGet('range')) 
        { 
            $range = explode(',', $range);
            $from = $range[0];
            $to   = $range[1];
        }

        if ($this->chart === 'visitors') 
        {
            $stats_m = model('App\Models\AnalyticsModel', false);
            $metrics = 'm_'. (!empty($this->metric) ? $this->metric : 'visit'); 

            if ($request->getGet('chart') !== str_ireplace('m_', '', $metrics))  
                $from = $to = null; 
 
            $user_chart = $stats_m->$metrics()->analysis()->charts($week, $from, $to);
        } 
        else
        {
            if ($request->getGet('chart') !== 'users')  
                $from = $to = null; 

            $stats_m = model('App\Models\StatsModel', false); 
            $user_chart = $stats_m->$chart($week, $from, $to);
        }

        $dates = $labels = [];
        $i     = $count  = 0;
        if (!empty($user_chart)) 
        {   
            $count = 0;
            foreach ($user_chart as $key => $chart) 
            {
                $i++;
                $count    += $chart['count'];
                $labels[] = [
                    'id' => $i, 
                    'label' => self::ordinal(date('j', strtotime($chart['dated']))). ' ' . date('M', strtotime($chart['dated'])), 
                    'data' => $chart['count']
                ]; 
            } 
        }  
        $label['count'] = $count;
        $label['items'] = json_encode($labels);  
        return $label;
    }
    
    public function statsJsVars($add_script = false, $load = false)
    {
        if ($load === true) 
        {
            $users    = $this->statsConf('o', 'users')->statsCharts();  
            $visitors   = $this->statsConf('o', 'visitors')->statsCharts();
            $validation = $this->statsConf('o', 'visitors', 'validation')->statsCharts();   
            $activation = $this->statsConf('o', 'visitors', 'activation')->statsCharts();
     
            $vars = ($add_script == true) ? "
            <script type=\"text/javascript\">\n" : "\n";
     
            $vars .= "var users_data_set  = {$users['items']}\n"; 
            $vars .= "var visitors_data_set  = {$visitors['items']}\n"; 
            $vars .= "var validation_data_set = {$validation['items']}\n"; 
            $vars .= "var activation_data_set  = {$activation['items']}"; 
     
            $vars .= ($add_script == true) ? "
                addEventListener('load', function() {
                    $('.users_data_set').html({$users['count']});
                    $('.visitors_data_set').html({$visitors['count']});
                    $('.validation_data_set').html({$validation['count']});
                    $('.activation_data_set').html({$activation['count']});
                })
            </script>\n" : "\n";

            return $vars;
        }
    }
}