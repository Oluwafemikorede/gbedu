<?php 
namespace Controllers;

use Core\View;
use Core\Controller;

use Helpers\Auth;

/*
 * Welcome controller
 *
 * @author David Carr - dave@daveismyname.com - http://www.daveismyname.com
 * @version 2.1
 * @date June 27, 2014
 */
class Dashboard extends Controller{

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

		$this->data['title'] = 'Admin Dashboard';


		View::rendertemplate('header', $this->data);
		View::rendertemplate('sidebar', $this->data);
		View::render('dashboard/dashboard.index', $this->data);
		View::rendertemplate('footer', $this->data);
	} 

}
