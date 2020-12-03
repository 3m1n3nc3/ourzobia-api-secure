<?php 

use Config\Services;
use \App\Libraries\Account_Data;
use \App\Libraries\Payment_processor;
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
    function theme_loader($data = array(), $view = '', $segment = 'user'): string
    { 
        if (my_config('site_theme', null, 'default') || my_config('admin_theme', null, 'default')) 
        {
            $_data['_request']         = \Config\Services::request(); 
            if (empty($account_data)) 
                $_data['account_data'] = $_data['acc_data'] = new Account_Data; 
            if (empty($paystack_lib)) 
                $_data['paystack_lib'] = new Payment_processor;
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
            if (empty($contentModel)) 
                $_data['contentModel'] = model('App\Models\ContentModel', false); 
            if (empty($data['postsModel'])) 
                $_data['postsModel']   = model('App\Models\PostsModel', false);
            if (empty($hubs_m)) 
                $_data['hubs_m']       = model('App\Models\HubsModel', false);
            if (empty($products_m)) 
                $_data['products_m']   = model('App\Models\ProductsModel', false);
            if (empty($bookings_m)) 
                $_data['bookings_m']   = model('App\Models\BookingsModel', false); 
            if (empty($data['profile'])) 
                $_data['profile']      = fetch_user('', $data['uid']??null);
            
            $data  = array_merge($_data, $data);
            $theme = set_theme($segment);

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
    function load_widget($widget, $data = array(), $segment = 'user'): string
    { 
        $uid = (!empty($data['uid'])) ? $data['uid'] : user_id(); 

        $acc_dt = new Account_Data;
        $widget = str_ireplace(['_widget'], '', $widget);
        $_data['acc_data'] = $acc_dt;  
        if ($uid) 
        {
            $_data['user'] = $acc_dt->fetch($uid);
        }
         
        $data    = array_merge($_data, $data);

        if (!empty($data['segment'])) 
        {
            $segment = $data['segment'];
        }

        $find     = APPPATH . 'Views/' . set_theme($segment) . 'widgets/' . $widget . '_widget.php'; 

        $append      = (file_exists($find)) ? '_widget' : '';
        $load_widget = 'widgets/' . $widget . $append;

        if (!file_exists(APPPATH . 'Views/' . set_theme($segment) . $load_widget . '.php')) 
        {
            return alert_notice($widget . " widget is not available for " . str_replace('/', '', set_theme($segment)) . " theme", "error");
        }

        return theme_loader($data, $load_widget, $segment);
    }
}  

if (! function_usable('set_theme'))
{
    /**
     * Set the theme to use
     *  
     * @return string
     */
    function set_theme($segment = 'user'): string
    {
        if ($segment == 'admin' && my_config('admin_theme', null, 'default')) 
        {
            $theme = my_config('admin_theme', null, 'default');
        }
        elseif ($segment == 'user' && my_config('site_theme', null, 'default')) 
        {
            $theme = my_config('site_theme', null, 'default');
        }
        elseif ($segment == 'front' && my_config('frontend_theme', null, 'default')) 
        {
            $theme = my_config('frontend_theme', null, 'default');
        }
        elseif (!empty($segment['theme'])) 
        {
            $theme = $segment['theme'];
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
        $theme = require($info_file);

        if ($info) 
        {
           return !empty($theme[$info]) ? $theme[$info] : '';
        }
        return $theme; 
    }
}
 

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
        $lang_file = my_config('lang_pack', null, 'Default_');

        return lang("$lang_file.$line", $args, service('request')->getLocale());
    }
}


if (! function_usable('select_lang'))
{
    /**
     * A convenience method to create a selectable language options 
     *  
     * @param string    $data
     * @param string    $selected
     *
     * @return string
     */
    function select_lang($data = '', $selected = '', $getLocale = false)
    {
        $valid_options = false;
        $locale    = ($getLocale === false) ? service('request')->getLocale() : '';
        $languages = directory_map(set_realpath(APPPATH.'Language/' . $locale, TRUE), 1); 

        $form = '<select ' . $data . ">\n";
        foreach ($languages as $key => $lang) 
        {
            $ext   = '.' . pathinfo($lang, PATHINFO_EXTENSION); 
            $lang  = str_ireplace([$ext,'/'], '', $lang); 
            $_lang = str_ireplace(['_'], '', $lang); 
 
            if (stripos($_lang, 'Validation') === FALSE && (stripos($lang, '_') !== FALSE || $getLocale))
            {
                $valid_options = true;
                $form .= '<option value="' . htmlspecialchars($lang) . '"'
                . ($lang == $selected ? ' selected="selected"' : '') . '>'
                . $_lang . "</option>\n"; 
            }
        }

        if (!$valid_options)
        {
            $form .= "<option selected=\"selected\">No Options Available</option>\n";
        }

        return $form . "</select>\n";
    }
} 


if (! function_usable('read_lang'))
{
    /**
     * A convenience method to read the contents of a language file
     *  
     * @param string    $files
     *
     * @return string
     */
    function read_lang($file = '', $setlocale = NULL): array
    {
        $locale   = $setlocale ?? service('request')->getLocale();
        $language = APPPATH.'Language/' . $locale . '/' . $file . '.php'; 
        
        if (file_exists($language)) 
        {
            $language = set_realpath($language, TRUE); 
            return include($language); 
        }

        return [];
    }
} 


if (! function_usable('delete_lang'))
{
    /**
     * A convenience method to delete a language file
     *  
     * @param string    $files
     *
     * @return string
     */
    function delete_lang($file = '', $setlocale = NULL): bool
    { 
        $setting_m = model('App\Models\SettingsModel', false);
        $locale    = $setlocale ?? service('request')->getLocale();
        $language  = APPPATH.'Language/' . $locale . '/' . $file . '.php'; 
 
        if (file_exists($language)) 
        {
            $language = set_realpath($language, TRUE);  

            update_env(['app.defaultLocale' => 'en']);
            $setting_m->save_settings(['lang_pack' => 'Default_']); 

            return deleteAll($language); 
        }

        return false;
    }
} 


if (! function_usable('save_lang'))
{
    /**
     * A convenience method to update the contents of a language file
     *  
     * @param string    $data 
     *
     * @return string
     */
    function save_lang(string $file, array $data = [], $setlocale = NULL)
    {
        if (!empty($data) && !in_array($file, ['Default','Default_']) || $setlocale) 
        {
            $locale   = $setlocale ?? service('request')->getLocale();

            if  ($setlocale) 
            {
                $language = APPPATH.'Language/' . $locale . '/Lang' . $setlocale . '_.php';
            }
            else
            {
                $language = set_realpath(APPPATH.'Language/' . $locale . '/' . $file . '.php', TRUE); 
            }
            
            $lang_pack = read_lang($file, ($setlocale?'en':null));
            $lang_pack = array_merge($lang_pack, $data); 

            $export_lang_pack = "<?php\n\n" . str_ireplace('array (', 'return [', var_export($lang_pack, true)) . ";\n?>";
            $export_lang_pack = str_ireplace(');', '];', $export_lang_pack);

            if (is_really_writable($language) || $setlocale) 
            {
                return file_put_contents($language, $export_lang_pack); 
            }
        }

        return false;
    }
} 


if (! function_usable('module_active'))
{
    /**
     * A convenience method to check if a module is active or available 
     *  
     * @param string    $module
     * @param string    $x_theme
     *
     * @return boolean
     */
    function module_active($module = '', $x_theme = null)
    {
        if ($x_theme === null)
            $theme  = (substr($module, 0, 1)==='_') ? my_config('admin_theme', null, 'default') : my_config('site_theme', null, 'default');
        else
            $theme = $x_theme;

        $active_mod = explode(',', (substr($module, 0, 1)==='_') ? my_config('admin_active_modules', null, implode(',', theme_info($theme,'modules'))) : my_config('site_active_modules'));
 
        if ($x_theme === null)
            return in_array($module, theme_info($theme,'modules')) && (in_array($module, $active_mod) OR empty($active_mod)); 
        else
            return in_array($module, theme_info($theme,'modules')); 
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
            if (stripos($value,'v.') !== false) 
            {  
                $version = str_ireplace('v.','',$value);
                $version_compare = version_compare(env('installation.version', '1.1.0'), $version, "<");
                $req .= (!$version_compare)?"<span class=\"text-success\">System v$version required</span> | ":"<span class=\"text-danger\">Upgrade system to v$version or higher to install</span> | ";
                if ($version_compare) $err = true;
            }
            elseif (stripos($value,'product.') !== false) 
            {
                $product = str_ireplace('product.','',$value);
                $product_compare = env('installation.product', 'hubboxx') === $product;
                $req .= (!$product_compare)?"<span class=\"text-danger\">Invalid Product for update</span> | ":"";
                if (!$product_compare) $err = true;
            }
            elseif (stripos($value,'dir.') !== false) 
            {
                $dir = str_ireplace('dir.','',$value);
                $req .= (is_really_writable(ROOTPATH.$dir))?"<span class=\"text-success\">$dir is writable</span> | ":"<span class=\"text-danger\">Make $dir writable</span> | ";
                if (!is_really_writable(ROOTPATH.$dir)) $err = true;
            }
            elseif (stripos($value,'ext.') !== false) 
            { 
                $ext = str_ireplace('ext.','',$value);
                $req .= (extension_loaded($ext))?"<span class=\"text-success\">$ext extension enabled</span> | ":"<span class=\"text-danger\">Enable $ext extension</span> | ";
                if (!extension_loaded($ext)) $err = true;
            }
            elseif (stripos($value,'ini.') !== false) 
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
