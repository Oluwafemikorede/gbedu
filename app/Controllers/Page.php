<?php 
namespace Controllers;

use Core\View;
use Core\Controller;

use Helpers\Session;
use Helpers\Url;
use Helpers\Gump;
use Helpers\Auth;

use Models\User;

/*
 * Welcome controller
 *
 * @author David Carr - dave@daveismyname.com - http://www.daveismyname.com
 * @version 2.1
 * @date June 27, 2014
 */
class Page extends Controller
{

	/**
	 * call the parent construct
	 */
	
	public function __construct(){
		parent::__construct();

	}

	/**
	 * define page title and load template files
	 */
	public function index(){	
		// var_dump('vchxhh');

		$page_model = new \Models\Page;
		$page_model->cmsPage();
		$this->data['page_title'] = \Models\Page::$pageName;

		$this->data['pagename'] = \Models\Page::$pageName;
		$this->data['subname'] = \Models\Page::$subName;
		$this->data['pagedetails'] = \Models\Page::$pagedetails;

		switch (\Models\Page::$controller) {
			case 'contact-us':
				Url::redirect('page/contact');
				break;
			
			default:
				# code...
				break;
		}

		View::renderTemplate('header',$this->data);
		View::render('page/page.index',$this->data);
		View::renderTemplate('footer',$this->data);
	}


	public function contact(){	
		// var_dump('vchxhh');

		$page_model = new \Models\Page;
		$page_model->cmsPage();
		$this->data['page_title'] = \Models\Page::$pageName;

		$this->data['pagename'] = \Models\Page::$pageName;
		$this->data['subname'] = \Models\Page::$subName;
		$this->data['pagedetails'] = \Models\Page::$pagedetails;



		View::renderTemplate('header',$this->data);
		View::render('page/page.contact',$this->data);
		View::renderTemplate('footer',$this->data);
	}
}