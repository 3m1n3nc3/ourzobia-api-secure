<?php 

use Config\Services;
use \App\Libraries\Util; 

 
if (! function_usable('_lang'))
{
 
    /**
     * A convenience method to translate a string or array of them and format
     * the result with the intl extension's MessageFormatter.
     * This is an alias of the built in Codeigniter lang() method
     *
     * @param string|[] $line
     * @param array     $args
     * @param string    $locale
     *
     * @return string
     */
    function _lang(string $line, array $args = [], string $locale = null)
    {
        $lang_file = "Default";

        return lang("$lang_file.$line", $args, '$locale');
    }
}
 
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
	function active_page($page = array(), $current_page = '', $add_class = false, $custom = false): string
	{
        $active_class = ($custom) ? $custom : 'active';

		if (is_array($page)) {
			if (in_array($current_page, $page)) 
            {
                if ($add_class === true) 
                {
                    return " class=\"$active_class\"";
                }
				return " $active_class";
			}
		}

        if ($page === $current_page) 
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
    function alert_notice($msg = '', $type = 'info', $echo = FALSE, $dismissible = TRUE, $header = NUll, $_title = NULL)
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

        $title = ($_title) ? $_title : $title;

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
                    <h6><i class="icon fa fa-'.$icon.'"></i> '.$title.'</h6>
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
    function my_config($item, $index = '')
    {   
        $setting_model = model('App\Models\SettingsModel', false);
        $config = $setting_model->get_settings($item);
        if ($index == '')
        {
            return isset($config) ? $config : '';
        }

        return isset($config[$index], $config[$index][$item]) ? $config[$index][$item] : '';
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