<?php 
namespace Controllers;

use Core\View;
use Core\Controller;

use Models\User;
use Models\Album;
use Models\Role;
use Models\Status;

use Helpers\Session;
use Helpers\Upload;
use Helpers\Url;
use Helpers\Auth;
use Helpers\Paginator;
use Helpers\PhpMailer\Mail;
use Helpers\Gump;
use Helpers\Cpanel\Cpmail;


/*
 * Welcome controller
 *
 * @author David Carr - dave@daveismyname.com - http://www.daveismyname.com
 * @version 2.1
 * @date June 27, 2014
 */
class Category extends Controller{

	/**
	 * call the parent construct
	 */
	public function __construct(){
		Auth::block();
		
		parent::__construct();

	}

	/**
	 * define page title and load template files
	 */
	public function index(){

		$this->data['title'] = 'Manage Categories';

		$category_model = new \Models\Category;

		$total = count($category_model->all());

		$pages = new Paginator('10','p');
		$this->data['category'] = $category_model->group($pages->getLimit());
		$pages->setTotal($total);
		$path = DIR.'category?';  
		$this->data['page_links'] = $pages->pageLinks($path,null);

		View::rendertemplate('header', $this->data);
		View::rendertemplate('sidebar', $this->data);
		View::render('category/category.index', $this->data);
		View::rendertemplate('footer', $this->data);
	} 



	public function item(){

		$this->data['title'] = 'Add Item';

		$category_model = new \Models\Category;

		$this->data['category_groups'] = $category_model->groupByCol('category_slug');

		if(isset($_POST) && !empty($_POST)){
			$category_title = $_POST['category_title'];
			$category_slug = $_POST['category_slug'];
			$category_created = time();

			$insert_array = array(
				'category_title'=>$category_title,
				'category_slug'=>$category_slug,
				'category_created'=>$category_created
				);

			$insert_array = Gump::xss_clean($insert_array);

			$insert_array = Gump::sanitize($insert_array);

			$insert_post_id = $category_model->create($insert_array);



			if($insert_post_id > 0){
				Session::set('success','category added');
				Url::redirect('category');
			}
		}

		View::rendertemplate('header', $this->data);
		View::rendertemplate('sidebar', $this->data);
		View::render('category/category.add', $this->data);
		View::rendertemplate('footer', $this->data);

	}


	public function edit($parameter){
		$item_id = $parameter[0];

		$this->data['title'] = 'Add Item';
		$this->data['page_section'] = 'edit';

		$category_model = new \Models\Category;

		$this->data['category'] = $category_model->find($item_id);


		if(isset($_POST) && !empty($_POST)){
			$category_title = $_POST['category_title'];
			$category_slug = $_POST['category_slug'];
			$category_modified = time();

			$update_array = array(
				'category_title'=>$category_title,
				'category_modified'=>$category_created
				);

			$update_array = Gump::xss_clean($update_array);

			$update_array = Gump::sanitize($update_array);

			$update_id = $category_model->updateId($update_array, $item_id);



			if($update_id > 0){
				Session::set('success','category edited');
				Url::redirect('category');
			}
		}

		View::rendertemplate('header', $this->data);
		View::rendertemplate('sidebar', $this->data);
		View::render('category/category.add', $this->data);
		View::rendertemplate('footer', $this->data);

	}


	public function delete($parameter){
		$item_id = $parameter[0];

		$category_model = new \Models\Category;

		$delete = $category_model->deleteId($item_id);

		if(isset($delete)){
			Session::set('success','record deleted');
			Url::previous();
		}

	}



}
