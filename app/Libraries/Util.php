<?php namespace App\Libraries; 

use App\Libraries\Notifications;
use \App\Libraries\Account_Data;

/**
 * Utility methods.
 */
class Util
{     
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

    public static function loggedInIsAJAX()
    {   
        $request  = \Config\Services::request();
        $response = \Config\Services::response();

        if (!$request->isAJAX() || !user_id())
        {      
            $code = 400;
            $msg  = 'The request was not understood!'; 

            if (!user_id()) 
            {
                $code = 401; 
                $msg  = 'You are currently not logged in, please login to continue!'; 
            }

            if (!$request->isAJAX())
            {
                $response->setStatusCode($code);
            }
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
        $form .= form_button(
            ['type' => 'submit', 'id' => 'rf_'.$item_id, 
            'class' => (!empty($this->alt_btn)) ? $this->alt_btn : 'btn-block btn ' . $btn_class . ' font-weight-bold mb-2',
            'onclick' => 'confirm(\'Are you sure?\')'], $title, $state);
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
            $data['referrer'] = $agent->referrer(); 
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
    
    public function statsJsVars($add_script = false)
    {
        $users    = $this->statsConf('o', 'users')->statsCharts();  
        $visitors    = $this->statsConf('o', 'visitors')->statsCharts();
        $validation  = $this->statsConf('o', 'visitors', 'validation')->statsCharts();   
        $activation  = $this->statsConf('o', 'visitors', 'activation')->statsCharts();
 
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