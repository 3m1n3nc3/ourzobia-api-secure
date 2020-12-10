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
	protected $helpers = ['form','ourfile', 'theme', 'filesystem', 'text', 'inflector', 'url', 'array', 'cookie', 'site', 'currency', 'icon','tp_plugins', 'mail', 'locale'];

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

        // Check if ourzobia has been installed
        if (env('installation.status', false) === false) 
        {
            if ($request->uri->getSegment(1) !== 'install') 
            {
                _redirect(prep_url($_SERVER['HTTP_HOST']).'/install/start');
            }
        }
        else
        {
	        // Init all models globally 
	        $this->form_validation = \Config\Services::validation();  
			$this->session         = \Config\Services::session();
	        $this->account_data    = new \App\Libraries\Account_Data;
	        $this->creative        = new \App\Libraries\Creative_lib;
	        $this->enc_lib         = new \App\Libraries\Enc_lib;
	        $this->util            = new \App\Libraries\Util;

	        $this->actives_m  = model('App\Models\ActivesModel', false);
	        $this->hubs_m     = model('App\Models\HubsModel', false);
	        $this->bookings_m = model('App\Models\BookingsModel', false);
	        $this->products_m = model('App\Models\ProductsModel', false);
	        $this->contentModel = model('App\Models\ContentModel', false);
	        $this->usersModel   = model('App\Models\UsersModel', false);
	        $this->settingModel   = model('App\Models\SettingsModel', false);
	        $this->statsModel     = model('App\Models\StatsModel', false);
	        $this->analyticsModel = model('App\Models\AnalyticsModel', false);
	        $this->postsModel     = model('App\Models\PostsModel', false);

	        if (!$this->session->has('visitor') && !$this->request->isAJAX() && !$this->request->getGetPost('domain') && stripos($this->request->getGetPost('origin'), 'alimon') === false)
	        {
	        	$this->session->set('visitor', true);
				$this->util->save_analysis('visits', 0);
	        }
        }
	}

}
