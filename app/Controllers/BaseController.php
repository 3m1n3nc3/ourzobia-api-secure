<?php
namespace App\Controllers;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 *
 * @package CodeIgniter
 */

use CodeIgniter\Controller;

class BaseController extends Controller
{

	/**
	 * An array of helpers to be loaded automatically upon
	 * class instantiation. These helpers will be available
	 * to all other controllers that extend BaseController.
	 *
	 * @var array
	 */
	protected $helpers = ['form','ourfile', 'theme', 'filesystem', 'text', 'inflector', 'url', 'array', 'cookie', 'site', 'currency'];

	/**
	 * Constructor.
	 */
	public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
	{
		// Do Not Edit This Line
		parent::initController($request, $response, $logger);

		//--------------------------------------------------------------------
		// Preload any models, libraries, etc, here.
		//--------------------------------------------------------------------  

        // Init all models globally 
        $this->form_validation = \Config\Services::validation();  
		$this->session         = \Config\Services::session();
        $this->account_data    = new \App\Libraries\Account_Data;
        $this->creative        = new \App\Libraries\Creative_lib;
        $this->enc_lib         = new \App\Libraries\Enc_lib;
        $this->util            = new \App\Libraries\Util;

        $this->products_m = model('App\Models\ProductsModel', false);
        $this->actives_m  = model('App\Models\ActivesModel', false);
        $this->usersModel = model('App\Models\UsersModel', false);
        $this->settingModel   = model('App\Models\SettingsModel', false);
        $this->statsModel     = model('App\Models\StatsModel', false);
        $this->analyticsModel = model('App\Models\AnalyticsModel', false);

        if (!$this->session->has('visitor') && !$this->request->isAJAX()) 
        {
        	$this->session->set('visitor', true);
			$this->util->save_analysis('visits', 0);
        }
	}

}
