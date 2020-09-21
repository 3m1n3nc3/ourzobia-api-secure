<?php 

use Config\Services;
use \App\Libraries\Account_Data;
use \App\Libraries\Paystack_validate;
use \App\Libraries\Creative_lib; 
use \App\Libraries\Enc_lib; 
use \App\Libraries\Util; 
use \App\Libraries\Notifications;

/**
 * CodeIgniter Security Helpers
 *
 * @package CodeIgniter
 */ 
 
if (! function_usable('theme_loader'))
{
    /**
     * Load the selected theme from the database
     *
     * @param  array  $data 
     * @return string|boolen
     */
    function theme_loader($data = array(), $view = ''): string
    { 
        if (my_config('theme')) 
        {
            $_data['_request']         = \Config\Services::request(); 
            if (empty($account_data)) 
                $_data['account_data'] = $_data['acc_data'] = new Account_Data; 
            if (empty($paystack_lib)) 
                $_data['paystack_lib'] = new Paystack_validate;
            if (empty($creative)) 
                $_data['creative']     = new Creative_lib; 
            if (empty($enc_lib)) 
                $_data['enc_lib']      = new Enc_lib; 
            if (empty($creative)) 
                $_data['util']         = new Util; 
            if (empty($notif)) 
                $_data['ntfn']         = new Notifications;
            if (empty($analytics_m)) 
                $_data['analytics_m']  = model('App\Models\AnalyticsModel', false);
            if (empty($data['profile'])) 
                $_data['profile']      = fetch_user('', $data['uid']??null);
            
            $data  = array_merge($_data, $data);
            $theme = set_theme();
 
            if ($view) 
            {
                if (!file_exists(APPPATH.'Views/' . $theme . $view . '.php')) $theme = 'default/';
                return view($theme . $view, $data);
            }

            if (!file_exists(APPPATH.'Views/' . $theme . 'index.php')) 
            {
                return view('default/' . 'index', $data);
            }

            return view($theme . 'index', $data);
        }
        return false;
    }
}
 
if (! function_usable('load_widget'))
{
    /**
     * Load a widget
     *
     * @param  string $widget
     * @param  array  $data
     * @return string
     */
    function load_widget($widget, $data = array()): string
    { 
        $uid = (!empty($data['uid'])) ? $data['uid'] : null; 

        $acc_dt = new Account_Data;
        $widget = str_ireplace(['_widget'], '', $widget);
        $_data['acc_data']     = $acc_dt; 

        if (user_id($uid)) 
        {
            $_data['user']     = $acc_dt->fetch(user_id($uid));
        } 

        $find     = APPPATH . 'Views/' . set_theme() . 'widgets/' . $widget . '_widget.php';
        $find_alt = APPPATH . 'Views/' . set_theme() . 'widgets/' . $widget . '.php';

        $append      = (file_exists($find)) ? '_widget' : '';
        $load_widget = 'widgets/' . $widget . $append;

        return theme_loader($data, $load_widget);
    }
}  

if (! function_usable('set_theme'))
{
    /**
     * Set the theme to use
     *  
     * @return string
     */
    function set_theme(): string
    {
        if (my_config('theme')) 
        {
            $theme = my_config('theme');
        }
        else
        {
            $theme = 'default';
        }

        return $theme . '/';
    }
}

 
if (! function_usable('fetch_themes'))
{
    function fetch_themes($restrict = '', $info = '')
    {
        $directories = directory_map(set_realpath(APPPATH.'/Views', TRUE), 1);
        $theme  = [];

        foreach ($directories as $key => $directory) 
        {
            if (stripos($directory, '/') !== FALSE && $directory !== 'errors/')
            {
                if (!$restrict || in_array($restrict, theme_info(rtrim($directory, '/'), 'stable'))) 
                {
                    $theme_name = rtrim($directory, '/');
                    if ($info) 
                    {
                        $theme[] = theme_info($theme_name, $info);
                    }
                    else
                    {
                        $theme[] = $theme_name;
                    }
                }
            }
        }

        return $theme;
    }
}


if (! function_usable('select_theme'))
{
    function select_theme($themes = [], $attr = '', $selected = '')
    {
        $form     = '<select ' . $attr . ">\n";
        foreach ($themes as $key => $val)
        {
            $form .= '<option value="' . htmlspecialchars($val) . '"'
                . ($val == $selected ? ' selected="selected"' : '') . '>'
                . theme_info($val, 'name') . "</option>\n"; 
        }

        return $form . "</select>\n";
    }
}


if (! function_usable('select_theme_modes'))
{
    function select_theme_modes($theme = '', $attr = '', $selected = '')
    {
        $form     = '<select ' . $attr . ">\n";
        foreach (theme_info($theme, 'modes') as $key => $mode)
        {
            $form .= '<option value="' . htmlspecialchars($mode) . '"'
                . ($mode == $selected ? ' selected="selected"' : '') . '>'
                . ucwords($mode) . "</option>\n"; 
        }

        return $form . "</select>\n";
    }
}


if (! function_usable('theme_info'))
{
    function theme_info($theme_name = '', $info = '')
    { 
        $file = APPPATH.'Views/' . $theme_name;

        if (!file_exists($file)) 
        {
            $file = APPPATH.'Views/default';
        }
        $theme_directory = set_realpath($file, TRUE);
        $info_file = $theme_directory . 'info.php';
        require $info_file;

        if ($info) 
        {
           return !empty($theme[$info]) ? $theme[$info] : '';
        }
        return $theme; 
    }
}


if (! function_usable('module_active'))
{
    function module_active($module = '')
    { 
        return in_array($module, theme_info(my_config('theme'),'modules'));
    }
}


if (! function_usable('check_requirements'))
{
    function check_requirements(array $array)
    {    
        $req = '| ';
        $err = false;  

        foreach($array AS $key => $value)
        {
            if (stripos($value,'dir.',) !== false) 
            {
                $dir = str_ireplace('dir.','',$value);
                $req .= (is_really_writable(ROOTPATH.$dir))?"<span class=\"text-success\">$dir is writable</span> | ":"<span class=\"text-danger\">Make $dir writable</span> | ";
                if (!is_really_writable(ROOTPATH.$dir)) $err = true;
            }
            elseif (stripos($value,'ext.',) !== false) 
            { 
                $ext = str_ireplace('ext.','',$value);
                $req .= (extension_loaded($ext))?"<span class=\"text-success\">$ext extension enabled</span> | ":"<span class=\"text-danger\">Enable $ext extension</span> | ";
                if (!extension_loaded($ext)) $err = true;
            }
            elseif (stripos($value,'ini.',) !== false) 
            { 
                $ini = explode('.', str_ireplace('ini.','',$value)); 
                $ini_k = $ini[0];
                $ini_v = !empty($ini[1]) ? $ini[1] : 1;
                $ini_check = is_numeric($ini_v) ? ini_get($ini_k) >= $ini_v : ini_get($ini_k) == $ini_v;
                $req .= ($ini_check) ? "<span class=\"text-success\">$ini_k is ok</span> | ":"<span class=\"text-danger\">Set $ini_k to $ini_v or higher</span> | ";
                if (ini_get($ini_k) != "1") $err = true;
            }
        }
        return ['info'=>$req, 'error'=>$err];
    }
}
