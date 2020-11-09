<?php 

use Config\Services;
use \App\Libraries\Util; 
use \n1ghteyes\apicore\client;
use \CodeIgniter\HTTP\Response; 

/**
 * CodeIgniter Security Helpers
 *
 * @package CodeIgniter
 */ 
 
if (! function_usable('active_page'))
{
	/**
	 * Set the active class for the current page
	 *
	 * @param  string $str
	 * @return string
	 */
    function active_page($page = array(), $current_page = '', $add_class = false, $custom = false, $reverse = false): string
    {
        $active_class = ($custom) ? $custom : 'active';

        if (!is_bool($reverse)) 
        { 
            if ($page === $current_page) 
            {
                return " $active_class";
            }
            return " $reverse";
        }

        if (is_array($page)) {
            if (($reverse === false && in_array($current_page, $page)) || ($reverse === true && !in_array($current_page, $page))) 
            { 
                if ($add_class === true) 
                {
                    return " class=\"$active_class\"";
                }
                return " $active_class";
            }
            return '';
        }

        if (($reverse === false && $page === $current_page) || ($reverse === true && $page !== $current_page)) 
        {
            if ($add_class === true) 
            {
                return " class=\"$active_class\"";
            }
            return " $active_class";
        }
        return '';
    }
} 


//--------------------------------------------------------------------


if ( ! function_usable('error_redirect')) 
{
    function error_redirect($condition = true, $type = '404', $check = false)
    {
        if (empty($condition) && $check === false) 
        {
            return redirect()->to(base_url('error/' . $type));
        }

        if (empty($condition) && $check === true) {
            return false;
        }
        return TRUE;
    }
}


//--------------------------------------------------------------------


if ( ! function_usable('localhosted')) 
{
    function localhosted($offline_access = false)
    {
        $request = \Config\Services::request();
        $uri     = $request->uri;
        $url     = $uri->getHost();

        $domain_path = pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION);
        $domain_name = pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_FILENAME);

        $arr       = array("localhost","127.0.0.1","::1", $domain_name.".te", $domain_name.".test");
        if( in_array( $url, $arr ) OR $offline_access )
        { 
            return TRUE;
        }

        return FALSE;
    }
}
//--------------------------------------------------------------------


if ( ! function_usable('account_access')) 
{
    function account_access($uid = '', $check = false)
    { 
        $users_m   = model('App\Models\UsersModel', false);
        $user      = $users_m->get_user_relevant($uid);
        $logged    = $users_m->get_user_relevant(user_id());
        $condition = (!empty($user['uid']) && ($uid == user_id() OR $logged['admin']));

        return error_redirect($condition, '401', $check);
    }
} 

//--------------------------------------------------------------------


if ( ! function_exists('encode_html') ) 
{
    function encode_html($html = "")
    {
        return htmlspecialchars($html);
    }
}


//--------------------------------------------------------------------


if ( ! function_exists('decode_html') ) 
{
    function decode_html($html = "")
    {
        return htmlspecialchars_decode($html);
    }
}


//--------------------------------------------------------------------


if ( ! function_exists('showBBcodes'))
{ 

    /** 
    * A simple PHP BBCode Parser function
    *
    * @author Afsal Rahim
    * @link http://digitcodes.com/create-simple-php-bbcode-parser-function/
    * Extended by passtech
    * 
    **/

    //BBCode Parser function

    function showBBcodes($text, $class = '') {
        // BBcode array
        $find = array(
            '~\[b\](.*?)\[/b\]~s',
            '~\[i\](.*?)\[/i\]~s',
            '~\[u\](.*?)\[/u\]~s',
            '~\[quote\](.*?)\[/quote\]~s',
            '~\[size=(.*?)\](.*?)\[/size\]~s',
            '~\[color=(.*?)\](.*?)\[/color\]~s',
            '~\[link=(.*?)\ class=(.*?)\](.*?)\[/link\]~s',
            '~\[link=(.*?)\](.*?)\[/link\]~s',
            '~\[url\]((?:ftp|https?)://.*?)\[/url\]~s',
            '~\[img\](https?://.*?\.(?:jpg|jpeg|gif|png|bmp))\[/img\]~s'
        );

        $class = ($class ? ' class="' . $class .'" ' : '');

        // HTML tags to replace BBcode
        $replace = array(
            '<'.$class.'b>$1</b>',
            '<'.$class.'i>$1</i>',
            '<'.$class.'span style="text-decoration:underline;">$1</span>',
            '<'.$class.'pre>$1</'.'pre>',
            '<span'.$class.' style="font-size:$1px;">$2</span>',
            '<span'.$class.' style="color:$1;">$2</span>',
            '<a href="$1" class="$2">$3</a>',
            '<a'.$class.' href="$1">$2</a>',
            '<a'.$class.' href="$1">$1</a>',
            '<img'.$class.' src="$1" alt="" />'
        );

        // Replacing the BBcodes with corresponding HTML tags
        return preg_replace($find,$replace,$text);
    }

    // How to use the above function:

    // $bbtext = "This is [b]bold[/b] and this is [u]underlined[/u] and this is in [i]italics[/i] with a [color=red] red color[/color]";
    // $htmltext = showBBcodes($bbtext);
    // echo $htmltext; 
}   


//--------------------------------------------------------------------


if (! function_usable('ppercentage'))
{
    /**
     * Calculate the percentage of completion for a given time 
     * against a duration for a number of units
     *
     * @param  string $strtotime
     * @param  string $duration
     * @param  string $unit
     * @return string
     */
    function ppercentage($strtotime, $duration, $unit = 'days'): string
    {
        $duration = ($duration <= 0) ? 1 : $duration;
        $acc_data = new \App\Libraries\Account_Data;
        $percent  = ($acc_data->days_diff($strtotime, 'NOW', $unit) / $duration)*100;
        $percent  = $percent > 100 ? 100 : $percent;
        return number_format($percent, 2);
    }
} 


//--------------------------------------------------------------------


if (! function_usable('payment_methods'))
{
    /**
     * List payment methods selectable via the pop upload box and others
     *
     * @param  string $index
     * @return array|string
     */
    function payment_methods($index = ''): array
    {
        $methods = [
            'ussd'   => 'Mobile/USSD',
            'atm'    => 'ATM Transfer',
            'mobile' => 'Mobile Transfer',
            'bank'   => 'Bank Payment',
        ];
        return $index ? $methods[$index] : $methods;
    }
}


//--------------------------------------------------------------------


if (! function_usable('user_status'))
{
    /**
     * Show the users account status
     *
     * @param  array $data
     * @return string
     */
    function user_status(array $data = []): string
    {
        $status = $data['status'];
        $admin  = (!empty($data['admin']) ? '<i class="fa fa-user-secret text-danger"></i> ' : '');
        if ($status == 0) 
        {
            return $admin . '<span class="text-danger">Restricted</span>';
        }
        elseif ($status == 1) 
        {
            return $admin . '<span class="text-danger">Inactive</span>';
        }

        return $admin . '<span class="text-success font-weight-bold">Active</span>';
    }
}


//--------------------------------------------------------------------


if (! function_usable('product_status'))
{
    /**
     * Show the users account status
     *
     * @param  array $data
     * @return string
     */
    function product_status($status = ''): string
    { 
        if ($status == 0) 
        {
            return '<span class="text-danger"><i class="fa fa-times-circle mr-1"></i></span>';
        }

        return '<span class="text-success font-weight-bold"><i class="fa fa-check-circle mr-1"></i></span>';
    }
}


//--------------------------------------------------------------------


if ( ! function_usable('alert_notice'))
{
    function alert_notice($msg = '', $type = 'info', $echo = FALSE, $dismissible = TRUE, $header = NUll, $_title = NULL, $_tclass = NULL)
    {   
        $icon = $dismissible_alert = $dismiss_btn = '';
        if ($type == 'danger' || $type == 'error') 
        {
            $title = 'Error!';
            $icon = 'ban';
            $type = 'danger';
        } 
        elseif ($type == 'warning') 
        {
            $title = 'Warning!';
            $icon = 'exclamation-triangle';
        } 
        elseif ($type == 'info') 
        {
            $title = 'Notice';
            $icon = 'info';
        } 
        elseif ($type == 'success') 
        {
            $title = 'Success';
            $icon = 'check';
        }

        $title   = ($_title) ? $_title : $title;
        $_tclass = ($_tclass) ? ' class="'.$_tclass.'"' : '';

        if ($dismissible === TRUE || $dismissible === 'TRUE') 
        {
            $dismissible_alert = ' alert-dismissible';
            $dismiss_btn = ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
        }

        if ($msg != '') 
        {
            $alert = $header ? '<'.$header.'>' : '';

            if ($dismissible !== 'FLAT' && $dismissible !== 'TRUE') 
            {
                $alert .= 
                '<div class="alert alert-'.$type.$dismissible_alert.'">
                    '.$dismiss_btn.'
                    <h6'.$_tclass.'><i class="icon fa fa-'.$icon.'"></i> '.$title.'</h6>
                    '.str_ireplace(['.', '!'], ['.', '!'], $msg).'
                </div>';
            } else {
                $alert .= 
                '<div class="alert alert-'.$type.$dismissible_alert.'">
                    '.$dismiss_btn.'
                    <i class="icon fa fa-'.$icon.'"></i>
                    '.str_ireplace(['.', '!'], ['.', '!'], $msg).'
                </div>';
            }

            $alert .= $header ? '</'.$header.">\n" : '';

            if ($echo) 
            {
                echo $alert;
                return;
            }
            return $alert;
        }
        return;
    }
} 


//--------------------------------------------------------------------


if ( ! function_usable('number'))
{
    function phone_number_format($number): string 
    {
        // Allow only Digits, remove all other characters.
        $number = preg_replace("/[^\d]/","",$number);
        
        if (stripos($number, '0') === 0) 
        { 
            $number = substr($number, 1);
        }
        // get number length.
        $length = strlen($number);
     
        // if number = 10
        if($length == 10) {
            $number = preg_replace("/^1?(\d{3})(\d{3})(\d{4})$/", "$1$2$3", $number);
        }

        return $number;
     
    }
}


//--------------------------------------------------------------------


if ( ! function_usable('phone_number'))
{
    function phone_number($number, $code = null) 
    {         
        if (my_config('reg_mode') == 0) 
        {              
            // if number = 10
            if(strlen($number) > 10 && stripos($number, '0') === 0) 
            {
                $number = substr($number, 1);
            } 

            $number = ($code == '234' ? '0' : '+' . $code) . $number;
        } 
      
        return $number;
    }
}


//--------------------------------------------------------------------


if ( ! function_usable('my_config'))
{   
    /**
     * Loads the config from database
     * @param  string $item   
     * @param  string $index  
     * @return string         
     */
    function my_config($item, $index = '', $default = null)
    {   
        $setting_model = model('App\Models\SettingsModel', false);
        $config = $setting_model->get_settings($item);
        if ($index == '')
        {
            return isset($config) ? $config : (isset($default) ? $default : '');
        }

        return isset($config[$index], $config[$index][$item]) ? $config[$index][$item] : (isset($default) ? $default : '');
    }
}

//--------------------------------------------------------------------


if ( ! function_usable('user_id'))
{   
    /**
     * Returns the numeric user_id of the currently logged in user
     * @return string
     */
    function user_id($default = null)
    {    
        $session      = \Config\Services::session();   
        $account_data = new \App\Libraries\Account_Data;
        $usersModel   = model('App\Models\usersModel', false);

        if (isset($default)) 
        {
            return $default;
        }
        
        if ($account_data->logged_in()) 
        {
            $_user = ($session->get('username') ?? get_cookie('username'));
            $user  = $usersModel->user_by_username($_user); 
            return $user['uid'];
        }
        return NULL;
    }
} 


if ( ! function_usable('logged_user'))
{   
    /**
     * Returns data for the currently logged user
     * @param  string $row 
     * @return string|array
     */
    function logged_user(string $row = '')
    {    
        $session      = \Config\Services::session();   
        $account_data = new \App\Libraries\Account_Data;
        $usersModel   = model('App\Models\usersModel', false); 
        
        if ($account_data->logged_in()) 
        {
            $_user = ($session->get('username') ?? get_cookie('username'));
            $user  = $usersModel->user_by_username($_user); 
            return ($row) ? $user[$row] : $user;
        }
        return ($row) ? false : [];
    }
}

if ( ! function_usable('fetch_user'))
{   
    /**
     * Returns data for the selected or currently logged user
     * @param  string $row 
     * @param  string $uid 
     * @return string|array
     */
    function fetch_user(string $row = '', $uid = null)
    {     
        $account_data = new \App\Libraries\Account_Data; 
        
        $user = $account_data->fetch(user_id($uid));
        if ($user) 
        {   
            if ($row && empty($user[$row])) 
            {
                $user[$row] = '';
            }
            return ($row) ? $user[$row] : $user;
        }

        return ($row) ? '' : [];
    }
}


//--------------------------------------------------------------------


if ( ! function_usable('show_countdown'))
{ 
    /**
     * Displays a countdown
     * @param  string            $time     unix timestamp or string to time operative (E.g. NOW+2 Days)
     * @param  boolean|string    $validate 
     *                           >true|false   either show a timer or a boolean indicating timer is still active
     *                           >WAIT         remove the duration if $past is in the future
     *                           >LEFT         show a timer or a string indicating left over time
     *                           >BLOCK        return a boolean if $past is in the past and timer has left over time
     * @param  string            $duration the duration for this timer
     * @param  string            $units    set the units for the timer (E.g. Hours)
     * @param  string            $class    set the class to display the timer in
     * @return string
     */
    function show_countdown(string $pre_date, $validate = FALSE, $duration = '24', $units = 'Hours', $class = 'text-danger')
    {   
        if (!is_numeric($pre_date)) 
            $pre_date = strtotime("$pre_date");  

        if ($validate === "WAIT" && !show_countdown($pre_date, 'BLOCK', $duration, $units)) 
        {
            $duration = '0';
            $class    = $class . ' deleted-line';
        }

        $future      = date('d-m-Y H:i:s', $pre_date); 
        $future_time = strtotime("$future + $duration $units"); 

        $time_left   = max($future_time-time(),0);

        if ($validate === true) 
        {   
            return ($time_left>0);
        } 
        elseif ($validate === "LEFT") 
        {   
            return $time_left;
        } 
        elseif ($validate === "BLOCK") 
        {
            return ($pre_date<=time() && $time_left>0);
        }

        $down_time = date('Y/m/d H:i:s', $future_time);

        $time_id   = $pre_date.rand();
        $time_pane = ($time_left>0) ? "
        <div 
            class=\"countdown_timer_alt $class\" 
            data-time=\"$down_time\" 
            id=\"timer$time_id\">
            {day:0} <small>Days</small> {hour:00} <small>Hrs</small> {min:00} <small>Min</small> {sec:00} <small>Sec</small>
        </div>\n" : "\n";
        return $time_pane;
    }
}


if ( ! function_usable('time_differentiator') ) 
{ 
    /**
     * Generates a time left string
     * 
     * @param string     $close     unix_timestamp
     * @param string     $far       unix_timestamp
     *
     * @return string
     */
    function time_differentiator(string $close = null, string $far = null, $tag = null, $class = "") 
    { 
        $close_time = new DateTime(date('Y-m-d H:i:s', $close));
        $far_time   = new DateTime(date('Y-m-d H:i:s', $far));
        $time_diff  = $close_time->diff($far_time);

        $tx = explode('.', $tag);
        $pre = !empty($tx[1]) ? $tx[1] : "";
        $tag = !empty($tx[0]) ? $tx[0] : "";

        if ($tag)
        {
            $stamp = "\n";
            $stamp .= $tag ? "<$tag" . ($class?" class=\"$class\"":'') .">$pre" : "";
            $stamp .= $time_diff->y ? "{$time_diff->y} Years " : '';
            $stamp .= $time_diff->m ? "{$time_diff->m} Months " : '';
            $stamp .= $time_diff->d ? "{$time_diff->d} Days " : '';
            $stamp .= $time_diff->h ? "{$time_diff->h} Hours " : ''; 
            $stamp .= $time_diff->i ? "{$time_diff->i} Minutes " : ''; 
            $stamp .= $tag ? "</$tag>\n" : "\n";
        }

        return $stamp;
    } 
}


//--------------------------------------------------------------------


if ( ! function_usable('diff2hours') ) 
{ 
    /**
     * Coverts the difference between two dates or timestamps to hours
     * 
     * @param string     $future     unix_timestamp/Date-time
     * @param string     $past       unix_timestamp/Date-time
     *
     * @return string
     */
    function diff2hours(string $future = "NOW", string $past = "NOW") 
    {  
        if (!is_numeric($future)) 
            $future = strtotime("$future"); 

        if (!is_numeric($past)) 
            $past = strtotime("$past");

        return ($future-$past)/3600;
    } 
}


//--------------------------------------------------------------------


if ( ! function_usable('toArray'))
{ 
    /**
     * Converts an object of standard class to an array
     * @param  object $obj 
     * @return array
     */
    function toArray($obj)
    {
        if (is_object($obj))
            $obj = (array) $obj;
        if (is_array($obj)) {
            $new = array();
            foreach ($obj as $key => $val) {
                $new[$key] = toArray($val);
            }
        } else {
            $new = $obj;
        }
        return $new;
    }
}


// --------------------------------------------------------------------


if ( ! function_usable('array_find'))
{
    /** 
     *
     * Searches an array for a similar string and returns the matches
     *
     * @param   string needle 
     * @param   array haystack 
     * @return  array
     */
    function array_find($needle, array $haystack, $key_value = true, $column = null): array
    {
        $keyArray = array();

        if(!empty($haystack[0]) && is_array($haystack[0]) === true) 
        { 
            // for multidimentional array
            foreach (array_column($haystack, $column) as $key => $value) 
            {
                if (strpos(strtolower($value), strtolower($needle)) !== false || strpos(strtolower($key), strtolower($needle)) !== false) 
                {
                    if ($key_value === true) 
                    {
                        $keyArray[$key] = $value;
                    }
                    else
                    {
                        $keyArray[] = $key;
                    }

                }
            }

        } else {
            foreach ($haystack as $key => $value) 
            { 
                // for normal array
                if (strpos(strtolower($value), strtolower($needle)) !== false || strpos(strtolower($key), strtolower($needle)) !== false) 
                {
                    if ($key_value === true) 
                    {
                        $keyArray[$key] = $value;
                    }
                    else
                    {
                        $keyArray[] = $key;
                    }
                }
            }
        } 

        return $keyArray;
    }
}


// --------------------------------------------------------------------


if ( ! function_usable('int_bool'))
{
    /** 
     *
     * Returns a boolen in place of integers 1 / 0, returns 1 for anything greater than 1.
     *
     * @param   integer 
     * @return  boolen
     */
    function int_bool(int $int = 1): bool
    {
        if ($int === 1 || $int >= 1) 
        {
            return TRUE;
        } 
        else 
        {
            return FALSE;
        } 
    }
}    

// ------------------------------------------------------------------------

if ( ! function_usable('_redirect'))
{
    /**
     * Header Redirect
     *
     * From Codeigniter v3
     * Header redirect in two flavors
     * For very fine grained control over headers, you could use the Output
     * Library's set_header() function.
     *
     * @param   string  $uri    URL
     * @param   string  $method Redirect method
     *          'auto', 'location' or 'refresh'
     * @param   int $code   HTTP Response status code
     * @return  void
     */
    function _redirect($uri = '', $method = 'auto', $code = NULL)
    {
        if ( ! preg_match('#^(\w+:)?//#i', $uri))
        {
            $uri = site_url($uri);
        }

        // IIS environment likely? Use 'refresh' for better compatibility
        if ($method === 'auto' && isset($_SERVER['SERVER_SOFTWARE']) && strpos($_SERVER['SERVER_SOFTWARE'], 'Microsoft-IIS') !== FALSE)
        {
            $method = 'refresh';
        }
        elseif ($method !== 'refresh' && (empty($code) OR ! is_numeric($code)))
        {
            if (isset($_SERVER['SERVER_PROTOCOL'], $_SERVER['REQUEST_METHOD']) && $_SERVER['SERVER_PROTOCOL'] === 'HTTP/1.1')
            {
                $code = ($_SERVER['REQUEST_METHOD'] !== 'GET')
                    ? 303   // reference: http://en.wikipedia.org/wiki/Post/Redirect/Get
                    : 307;
            }
            else
            {
                $code = 302;
            }
        }

        switch ($method)
        {
            case 'refresh':
                header('Refresh:0;url='.$uri);
                break;
            default:
                header('Location: '.$uri, TRUE, $code);
                break;
        }
        exit;
    }
}


if ( ! function_usable('create_url') ) 
{  
    /**
     * Return a site URL to use in views, more useful before installation
     *
     * @param mixed            $uri       URI string or array of URI segments
     * @param string|null      $protocol
     * @param \Config\App|null $altConfig Alternate configuration to use
     *
     * @return string
     */
    function create_url($uri = '', string $protocol = null, \Config\App $altConfig = null): string
    {
        // convert segment array to string
        if (is_array($uri))
        {
            $uri = implode('/', $uri);
        }

        // use alternate config if provided, else default one
        $config = $altConfig ?? config(\Config\App::class);

        $fullPath = rtrim(prep_url($_SERVER['HTTP_HOST']), '/') . '/';

        // Add index page, if so configured
        if (! empty($config->indexPage))
        {
            $fullPath .= rtrim($config->indexPage, '/');
        }
        if (! empty($uri))
        {
            $fullPath .= '/' . $uri;
        }

        $url = new \CodeIgniter\HTTP\URI($fullPath);

        if (empty($protocol)) 
        {
            $protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') ? 'https' : 'http';
        }

        // allow the scheme to be over-ridden; else, use default
        if (! empty($protocol))
        {
            $url->setScheme($protocol);
        }

        return (string) $url;
    }
}

if ( ! function_usable('timeAgo') ) 
{
    /**
     * Time Difference function
     */     
    function timeAgo($time, $x=0)
    {
        // Use strtotime() function to convert your time stamps before sending to the plugin

        $time_difference = time() - $time;

        if($time_difference < 1 && $x==0) { return 'less than 1 second ago'; }
        $seconds = array( 12 * 30 * 24 * 60 * 60 =>  'year',
                    30 * 24 * 60 * 60       =>  'month',
                    24 * 60 * 60            =>  'day',
                    60 * 60                 =>  'hour',
                    60                      =>  'minute',
                    1                       =>  'second', 
                   -1                       =>  'millisecond' 
        );

        foreach( $seconds as $secs => $ret )
        {
            $diff = $time_difference / $secs;

            if( $diff >= 1 )
            {
                $t = round( $diff );
                $y = $ret == 'hour' || $ret == 'minute' || $ret == 'second' || $ret == 'millisecond' ? true : false;
                // Check the request type
                if ($x == 1) {
                    if ($ret == 'day' && $t==1) {
                        // If the time is been more than a day but less than two show yesterday
                        return date('h:i A', $time).' | Yesterday'; 
                    } elseif ($ret == 'year') {
                        // If the time is been up to a year show full year
                        return date('h:i A', $time).' | '.date('F j Y', $time); 
                    } elseif ($y) {
                        // If the time is been less than or equal to a day show today
                        return date('h:i A', $time).' | Today'; 
                    } else {
                        // If the time is been more than two days show the date
                        return date('h:i A', $time).' | '.date('F j', $time); 
                    }                   
                } elseif ($x == 2) {
                    // Show only date
                    if ($ret == 'year' && $t==1) {
                        // If the time is been more than a day but less than two show yesterday
                        return date('M j Y', $time);
                    } else {
                        return date('M j', $time);
                    }
                } else {
                    return 'About ' . $t . ' ' . $ret . ( $t > 1 ? 's' : '' ) . ' ago';
                }
            }
        }
    }
}


if ( ! function_usable('delete_dir') ) 
{
    function delete_dir($dirPath, $skipable = false) {
        if (!is_dir($dirPath)) {
            throw new InvalidArgumentException("$dirPath must be a directory");
        }
        if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
            $dirPath .= '/';
        } 
        $files = glob($dirPath . '*', GLOB_MARK);
        foreach ($files as $file) { 
            if (!is_writable($file)) chmod($file, 0777);
            if (!is_writable($file)) return $skipable;
            if (is_dir($file)) {
                delete_dir($file);
                if (file_exists($file)) rmdir($file);
            } else { 
                unlink($file);
            }
        }
        if (rmdir($dirPath)) {
            return true;
        }
        return false;
    }
}

if ( ! function_usable('deleteAll') ) 
{
    function deleteAll($file) 
    {          
        // Check for files 
        if (is_file($file)) 
        {               
            // If it is file then remove by 
            // using unlink function 
            return unlink($file); 
        } 
        // If it is a directory. 
        elseif (is_dir($file)) 
        {               
            // Get the list of the files in this 
            // directory 
            $scan = glob(rtrim($file, '/').'/*'); 
              
            // Loop through the list of files 
            foreach($scan as $index=>$path) 
            { 
                // Call recursive function 
                deleteAll($path); 
            } 
            // Remove the directory itself 
            return @rmdir($file); 
        } 
    } 
} 

if ( ! function_usable('update_env') ) 
{
    /**
     * A convenience method to update the values of the .env file
     * Supply a $fields and $value or array of $fields => $value pairs to $fields
     * or set $fields to null and supply a qualified .env configuration string to $value
     *
     * @param string        $fields
     * @param string|int    $value 
     *
     * @return bool
     */
    function update_env($fields = null, $value = null) : bool
    {
        if ((!empty($fields) || !empty($value)) && (is_array($fields) OR $value)) 
        {
            $dot_env_path = ROOTPATH . '.env'; 

            @chmod($dot_env_path, 0666);
            $dot_env_file = file_get_contents($dot_env_path);
            $dot_env_file = trim($dot_env_file);

            if (is_array($fields)) 
            {
                foreach ($fields as $field => $value) 
                {
                    $curr_val     = env($field);

                    if (stripos($dot_env_file, $field) !== FALSE) 
                    {
                        $dot_env_file = str_replace("$field = $curr_val", "$field = $value", $dot_env_file);  
                    }
                    elseif (stripos($dot_env_file, "#---#") !== FALSE) 
                    {
                        $dot_env_file = str_replace("#---#", "#---#\n$field = $value", $dot_env_file);  
                    }
                } 
            }
            elseif (!empty($fields))
            {
                $curr_val     = env($fields);

                if (stripos($dot_env_file, $field) !== FALSE) 
                {
                    $dot_env_file = str_replace("$field = $curr_val", "$field = $value", $dot_env_file);  
                }
                elseif (stripos($dot_env_file, "#---#") !== FALSE) 
                {
                    $dot_env_file = str_replace("#---#", "#---#\n$field = $value", $dot_env_file);  
                }
            }
            elseif (!empty($value))
            {
                $dot_env_file = $value;  
            }

            if (!$fp = fopen($dot_env_path, 'wb')) 
            {
                return FALSE;
            }
            flock($fp, LOCK_EX);
            fwrite($fp, $dot_env_file, strlen($dot_env_file));
            flock($fp, LOCK_UN);
            fclose($fp);
            @chmod($dot_env_path, 0644);
            return TRUE;
        }

        return false;
    }
}

if ( ! function_usable('Alogic') ) 
{
    function Alogic($schema = 'https', $param = []) 
    {
        $session = \Config\Services::session();    
        $client  = \Config\Services::curlrequest();

        if (my_config('afterlogic_domain') && my_config('afterlogic_username') && my_config('afterlogic_password')) 
        { 
            try 
            { 
                if (!empty($param['auth'])) 
                {
                    $auth = $param['auth']; 
                }
                elseif ($session->has('afterlogic_auth'))
                {
                    $auth = $session->get('afterlogic_auth'); 
                }

                $params = [
                    'Module' => $param['Module'] ?? 'Core',
                    'Method' => $param['Method'] ?? 'Ping'
                ];

                if (!empty($param['Parameters'])) 
                {
                    $params['Parameters'] = json_encode($param['Parameters']);
                }

                if (empty($param['admin']) || $session->has('afterlogic_auth')) 
                {
                    $form_data['form_params'] = $params;
                    if (!empty($auth)) 
                    {
                        $form_data['headers'] = ['Authorization' => "Bearer $auth"];
                    }
     
                    $logic = json_decode($client->request('POST', $schema . '://'. my_config('afterlogic_domain') . '/?/Api', $form_data)
                        ->getBody()); 
                }
                else
                {    
                    $login = $client->request('POST', $schema . '://'. my_config('afterlogic_domain') . '/?/Api', [
                        'form_params' => [
                            'Module' => 'Core',
                            'Method' => 'Login',
                            'Parameters' => json_encode([
                                'Login'    => my_config('afterlogic_username'),
                                'Password' => my_config('afterlogic_password'),
                                'SignMe'   => true
                            ], JSON_FORCE_OBJECT)
                        ]
                    ]);

                    $logged_in = json_decode($login->getBody());

                    if (!empty($logged_in->Result->AuthToken)) 
                    {
                        $auth = $logged_in->Result->AuthToken;
                        $session->set('afterlogic_auth', $auth); 

                        $logic = json_decode($client->request('POST', $schema . '://'. my_config('afterlogic_domain') . '/?/Api', [
                            'headers' => ['Authorization' => "Bearer $auth"],
                            'form_params' => $params
                        ])->getBody()); 
                    }
                }
            }
            catch(\Exception $e)
            {
                return json_decode(json_encode(['Result' => false, 'Errors' => $e->getMessage()]));
            }

            return $logic;
        }
        else
        {
            return json_decode(json_encode(['Result' => false, 'Errors' => _lang("auth_failed_check_credentials", ["AfterLogic"])]));
        }
        
        return;
    } 
} 

if ( ! function_usable('Cpanel') ) 
{
    function Cpanel($schema = 'https') 
    {
        $cpanel_api = new client();
        if (my_config('cpanel_url') && my_config('cpanel_username') && my_config('cpanel_password')) 
        {
            $cpanel_api->setServer(my_config('cpanel_url'), my_config('cpanel_port'))->setBasePath('execute')->setSchema($schema . '://');
            $cpanel_api->auth(my_config('cpanel_username'), my_config('cpanel_password'));

            return $cpanel_api;
        }
        
        $cpanel_api->status = 0;
        $cpanel_api->errors = _lang("auth_failed_check_credentials", ["Cpanel"]);
        
        return $cpanel_api;
    } 
} 

if ( ! function_usable('IpApi') ) 
{
    function IpApi($address, $schema = 'http') 
    {
        $ip_api = new client();

        $address = is_numeric($address) ? '_'.$address : $address;

        $ip_api->justServer("api.ipapi.com")
            ->setSchema(my_config("ipapi_protocol", null, 'http') . '://')
            ->setBasePath("api")
            ->addQueryString(['access_key'=>my_config('ipapi_key'), 'output'=>'json']);

        return $ip_api->GET->$address();
    } 
}

if ( ! function_usable('CpanelErrors') ) 
{
    function CpanelErrors($errors = [], $field = NULL) 
    {
        if ($errors) 
        {
            $error_list = [];
            foreach ($errors as $key => $error) 
            {
                if ($field) 
                {
                    $error = "[$field error]: $error";
                }

                $error_list[] = $error; 
            }
            return implode("<br>\n", $error_list);
        }

        return false;
    } 
} 

if ( ! function_usable('range_maker') ) 
{
    function range_maker($from = [], $to = null, $array = true, $separator = ",") 
    {
        if (is_array($from)) 
        { 
            $separator = $from[3] ?? ",";
            $array     = $from[2] ?? true;
            $to        = $from[1] ?? 1;
            $from      = $from[0] ?? 0;
        }

        $to    = $to+1;
        $range = [];

        if (is_numeric($from) && is_numeric($to)) 
        { 
            for ($i=$from; $i < $to; $i++) 
            { 
                $from++;
                $range[] = $i;
            }
            
            if ($array === true) 
            {
                return $range;
            }
            
            return implode($separator, $range);
        }

        return false;
    } 
} 

if ( ! function_usable('array_string_blast') ) 
{ 
    /**
     * Takes a multidimensional array containing comma separated strings
     * and blasts the stings creating a new array with unique values from all 
     * elements in supplied array.
     *
     * @param array $array
     * @param string $index
     * @param boolean $prepare
     *
     * @return array
     */
    function array_string_blast(array $array = [], string $index, $prepare = false) 
    {
        $init = $data = [];
        foreach ($array as $key => $value) 
        {
            $init[] = str_ireplace(', ', ',', $value[$index]);
        }
            
        foreach (explode(',',implode(',', $init)) as $key => $value) 
        {
            $string = $value;

            if ($prepare === true) 
            {
                $string = ucwords(str_ireplace(['_','-'], ' ', $value));
            }

            $data[str_ireplace(' ', '_', $value)] = $string;
        }

        return $data;
    } 
}