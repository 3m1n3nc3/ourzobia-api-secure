<?php namespace App\Controllers\Install; 

// use App\Controllers\BaseController; 
use CodeIgniter\Controller;
use App\Libraries\Creative_lib;
use App\Libraries\Enc_lib;

class Start extends Controller {

    private $error = ''; 
    private $dot_env_path = ROOTPATH . '.env'; 
    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = ["site", "form", "filesystem", "tp_plugins"];  


    public function index() 
    { 
        $creative = new Creative_lib;
        $enc_lib  = new Enc_lib;

        $debug = '';
        $progress = 1;
        $progressing = array(
            1 => false,
            2 => false,
            3 => false,
        );
        if ($this->request->getPost())
        {
            if ($this->request->getPost('step') && $this->request->getPost('step') == 2) 
            {
                if ($this->request->getPost('hostname') == '') 
                {
                    $this->error = 'Hostname is required';
                } 
                else if ($this->request->getPost('database') == '') 
                {
                    $this->error = 'Enter database name';
                } 
                else if ($this->request->getPost('password') == '' && strpos(site_url(), 'localhost') === false && strpos(site_url(), '[::1]') === false) 
                {
                    $this->error = 'Enter database password';
                } 
                else if ($this->request->getPost('username') == '') 
                {
                    $this->error = 'Enter database username';
                }

                $progress = 2;

                $progressing[1] = true;

                if ($this->error === '') 
                {  
                    try 
                    {
                        $progressing[2] = true;
                        $link = mysqli_connect($this->request->getPost('hostname'), $this->request->getPost('username'), $this->request->getPost('password'), $this->request->getPost('database'));
                        $debug .= "<i class=\"fa fa-check-circle fa-sm text-white\"></i> Success: Connection to \"" . $this->request->getPost('database') . "\" database established.";
                        if ($this->write_db_config()) {
                            $progress = 3;
                        }
                        mysqli_close($link);
                    }
                    catch(\Exception $e) 
                    {
                        $this->error = $e->getMessage();
                    } 
                }
            } 
            else if ($this->request->getPost('step') && $this->request->getPost('step') == 3) 
            {
                if ($this->request->getPost('admin_email') == '') 
                {
                    $this->error = 'Enter admin email address';
                } 
                else if (filter_var($this->request->getPost('admin_email'), FILTER_VALIDATE_EMAIL) === false) 
                {
                    $this->error = 'Enter valid email address';
                } 
                else if ($this->request->getPost('admin_password') == '') 
                {
                    $this->error = 'Enter admin password';
                } 
                else if ($this->request->getPost('admin_password') != $this->request->getPost('admin_passwordr')) 
                {
                    $this->error = 'Your confirm password not match';
                }
                $progressing[1] = true;
                $progressing[2] = true;
                $progress = 3;
            } 
            else if ($this->request->getPost('requirements_success')) 
            {
                $progress = 2;
                $progressing[1] = true;
            }
            
            if ($this->error === '' && $this->request->getPost('step') && $this->request->getPost('step') == 3) 
            {
                $database = @file_get_contents(APPPATH . 'Controllers/Install/database.sql');
                
                $db = \Config\Database::connect(); 
  
                try 
                {
                    $db->query('SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";');

                    $password = $enc_lib->passHashEnc($this->request->getPost('admin_password'));

                    // if ($db -> multi_query($database))
                    if (mysqli_multi_query($db->connID, $database)) 
                    {
                        $this->clean_up_db_query();

                        $db->reconnect();
  
                        $usersModel   = model('App\Models\UsersModel', false);

                        $data = array(
                            'username' => $this->email2username($this->request->getPost('admin_email')),
                            'email'    => $this->request->getPost('admin_email'),
                            'fullname' => 'Super Admin',     
                            'admin_name' => 'Super',	 
                            'password' => $password,  
                            'admin'    => 4,
                            'status'   => 2
                        );
 
                        if (!$usersModel->user_by_username($data['username'])) 
                        {
                            $db->table('users')->insert($data); 
                        }

                        // Install the locale.sql
                        $locales = @file_get_contents(ROOTPATH . 'locale.sql');
                        $locales = explode(';', $locales); 
                        $locale_key = array('cities', 'countries', 'states'); 
 
                        foreach ($locales as $key => $locale) 
                        {
                            if (!empty($locale[$key]) && !$db->table($locale_key[$key])->selectCount('*', 'c')->get()->getRow()->c) 
                            {
                                $db->query($locales[$key]); 
                            } 
                        }  

                        $this->set_install_status();

                        if (!is_really_writable($this->dot_env_path)) 
                        {
                            show_error($this->dot_env_path . ' should be writable. Database imported successfully. And admin user created successfully. You can set manually in root after CI_ENVIRONMENT installation.status = installed');
                        }
 
                        $progressing[1] = true;
                        $progressing[2] = true;
                        $progressing[3] = true;
                        $progress = 4; 
                    }
                }
                catch(\Exception $e) 
                {
                    $error = $e->getMessage();
                }
            } 
            else 
            {
                $error = $this->error;
            }
        }
        include_once(APPPATH . 'Controllers/Install/container.php');
    }

    public function delete_install_dir() { 
        if (is_dir(APPPATH . 'Controllers/Install')) 
        {
            if (delete_dir(APPPATH . 'Controllers/Install', true)) 
            { 
                return redirect()->to(base_url('admin/dashboard'));
            }
        }
    }

    private function email2username(String $email)
    {    
        $email = explode('@', $email);
        array_pop($email); 
        return (String) $email[0];
    }  

    private function clean_up_db_query() {
        $db = \Config\Database::connect();
        while (mysqli_more_results($db->connID) && mysqli_next_result($db->connID)) 
        {
            $dummyResult = mysqli_use_result($db->connID);
            if ($dummyResult instanceof mysqli_result) 
            {
                mysqli_free_result($db->connID);
            }
        }
    }

    private function set_install_status() 
    {  
        return update_env([
            'installation.status'    => 'true',
            'CI_ENVIRONMENT.version' => 'production'
        ]); 
    }

    private function write_db_config() 
    {
        $new_dot_env_content =
"#--------------------------------------------------------------------
# ENVIRONMENT
#--------------------------------------------------------------------

CI_ENVIRONMENT = development
installation.status = false
installation.version = 1.0.0

#--------------------------------------------------------------------
# APP
#--------------------------------------------------------------------

app.baseURL = '".prep_url($_SERVER['HTTP_HOST']).'/'."'
app.forceGlobalSecureRequests = false
app.defaultLocale = en

#--------------------------------------------------------------------
# DATABASE
#--------------------------------------------------------------------

database.default.hostname = " . $this->request->getPost('hostname') . "
database.default.database = " . $this->request->getPost('database') . "
database.default.username = " . $this->request->getPost('username') . "
database.default.password = " . $this->request->getPost('password') . "
database.default.DBDriver = MySQLi

#--------------------------------------------------------------------
# OTHERS
# Please don't remove the #|---|# line
#--------------------------------------------------------------------
#---#";
        return update_env(null, $new_dot_env_content); 
    }
} 