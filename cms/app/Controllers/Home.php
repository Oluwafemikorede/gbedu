<?php 

namespace Controllers;

use Core\View;
use Core\Controller;

class Home extends Controller{

	/**
	 * call the parent construct
	 */
	public function __construct(){
		parent::__construct();

		$this->language->load('welcome');
	}

	/**
	 * define page title and load template files
	 */
	public function index(){

		$data['title'] = 'Welcome';
		$data['welcome_message'] = $this->language->get('welcome_message');

		View::rendertemplate('home_header', $this->data);
		View::rendertemplate('sidebar', $this->data);
		View::render('home/home.index', $this->data);
	}

}
