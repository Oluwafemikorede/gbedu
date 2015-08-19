<?php 

namespace Controllers;

use Core\View;
use Helpers\Url;
use Helpers\Session;
use Helpers\Gump;
use Helpers\Document;
use Helpers\Upload;
use Helpers\Paginator;
use Helpers\Auth;
use Models\User;
use Core\Controller;

/*
 * Welcome controller
 *
 * @author David Carr - dave@daveismyname.com - http://www.daveismyname.com
 * @version 2.1
 * @date June 27, 2014
 */
class Page extends Controller{

	/**
	 * call the parent construct
	 */
	public $pageModel;
	public $contentModel;
	public $albumModel;
	public $categoryModel;

	public function __construct(){
		parent::__construct();

		// $this->language->load('welcome');
	 $this->pageModel = new \Models\Page;
	 $this->contentModel = new \Models\Content;
	 $this->albumModel = new \Models\Album;
	 $this->categoryModel = new \Models\Category;

	 $this->data['album_group'] = $this->albumModel->all();


	}

	/**
	 * define page title and load template files
	 */
	public function index(){
		$action = $_GET['action'];

		$this->data['album_group'] = $this->albumModel->all();


		$this->data['parent_page'] = $this->pageModel->parent_page();
		$this->data['title'] = 'All Pages';

		if(isset($_POST) && !empty($_POST)){
			//PAGE DATA
			$pagename = $_POST['pagename'];
			$category = $_POST['category'];
			$parent_page = $_POST['parent_page'];
			$sort_order = $_POST['sort_order'];
			
			//CONTENT
			$content = $_POST['content'];
			$homepage = $_POST['homepage'];
			$header_menu = $_POST['header_menu'];
			$footer_menu = $_POST['footer_menu'];
			$redirecturl = $_POST['redirecturl'];
			$album = $_POST['album'];
			$meta_keywords = $_POST['meta_keywords'];
			$meta_title = $_POST['meta_title'];
			$meta_description = $_POST['meta_description'];
			// $sort_order = $_POST['sort_order'];


			$slug = Url::generateSafeSlug($pagename);

			$check_if_page_exist = $this->pageModel->get(array('page_alias'=>$slug));

			if(count($check_if_page_exist) < 1){

			$insert_array = array(
				'page_name'=>$pagename,
				'page_category_id'=>$category,
				'page_sort_order'=>$sort_order,
				'page_alias'=>$slug);

			$insert_page_id = $this->pageModel->create($insert_array);

			//UPDATE CONTENT PAGE
			if($parent_page == ''){
				$parent_page = $insert_page_id;
			}
			// var_dump($parent_page);


			$insert_content_array = array(
				'content_page_id'=>$insert_page_id,
				'content_subto'=>$parent_page,
				'content_plugin'=>$plugin,
				'content_body'=>$content,
				'content_homepage'=>$homepage,
				'content_header_menu'=>$header_menu,
				'content_footer_menu'=>$footer_menu,
				'content_redirecturl'=>$redirecturl,
				'content_album'=>$album,
				'content_meta_keywords'=>$meta_keywords,
				'content_meta_title'=>$meta_title,
				'content_meta_description'=>$meta_description,
				'content_created'=>time());

			$insert_content_array = Gump::xss_clean($insert_content_array);
			$insert_content_array = Gump::sanitize($insert_content_array);

			$insert_content_id = $this->contentModel->create($insert_content_array);

			//UPLOAD IMAGE
			$where_array = array('content_id'=>$insert_content_id);

					if($_FILES["image1_extra"]["tmp_name"] != '')
						{
							Upload::setName($slug.uniqid());
							Upload::upload_file($_FILES["image1_extra"],UPLOAD_PATH);
							
							$image_name = 'images/'.Upload::$filename;
							$update_data = array('content_banner' => $image_name);
							
							$update = $this->contentModel->update($update_data, $where_array);
						}


						if($_FILES["image2_extra"]["tmp_name"] != '')
						{
							Upload::setName($slug.uniqid());
							Upload::upload_file($_FILES["image2_extra"],UPLOAD_PATH);
							
							$image_name = 'images/'.Upload::$filename;
							$update_data = array('content_thumbnail' => $image_name);

							$update = $this->contentModel->update($update_data, $where_array);
						}


			if($insert_content_id > 0)
				$this->data['success'] = 'Page created!';
			else
				$this->data['error'] = 'Operation Fails!';

		} else {
				$this->data['error'] = 'Page already exists!';
		}
			
			$this->data['page_data'] = $this->pageModel->detail($insert_page_id);

		}


		

			if($message == 'ok'){
				$this->data['success'] = 'Record Deleted!';
			} else if($message == 'no'){
				$this->data['error'] = 'Operation Fails!';
			}

		

		$this->data['pages'] = $this->pageModel->allPages();
		$this->data['page_categories'] = $this->categoryModel->get(array('category_slug'=>'page'));

		View::rendertemplate('header', $this->data);
		View::rendertemplate('sidebar', $this->data);
		View::render('pages/pages.index', $this->data);
		View::rendertemplate('footer', $this->data);
	} 


	public function delete($param){
		// $type = $param[0];
		$delete_id = $param[0];

		// if($type == 'page')
			$delete = $this->pageModel->deleteId($delete_id);
		// else
		// 	$delete = $this->contentModel->delete(array('content_page_id'=>$delete_id));

		if($delete > 0)
			Session::set('success','Record Deleted!');
		else
			Session::set('error','Delete Fails!');
					
		Url::previous();

	}



	public function edit($param){
		$edit_id = $param[0];
		$action = $_GET['action'];

		$this->data['album_group'] = $this->albumModel->all();
		

		$this->data['title'] = 'Edit Page';

		if(isset($_POST) && !empty($_POST)){

			$pagename = $_POST['pagename'];
			$category = $_POST['category'];
			$sort_order = $_POST['sort_order'];
			$slug = Url::generateSafeSlug($pagename);

			$update_array = array(
				'page_name'=>$pagename,
				'page_category_id'=>$category,
				'page_sort_order'=>$sort_order,
				'page_alias'=>$slug);

			$where_array = array('page_id'=>$edit_id);

			$update_id = $this->pageModel->update($update_array,$where_array);

			if($update_id > 0){
				$message = 'ok';
			} else {
				$message = 'no';
			}

		}



			if($message == 'ok'){
				$this->data['success'] = 'Operation Successful!';
			} else if($message == 'no'){
				$this->data['error'] = 'Operation Fails!';
			}

		$this->data['pages'] = $this->pageModel->allPages();
		$this->data['page_data'] = $this->pageModel->detail($edit_id);
		$this->data['page_categories'] = $this->categoryModel->page();
		$this->data['parent_page'] = $this->pageModel->parent_page();

		View::rendertemplate('header', $this->data);
		View::rendertemplate('sidebar', $this->data);
		View::render('pages/page.edit', $this->data);
		View::rendertemplate('footer', $this->data);
	} 


	public function addcontent(){
			$action = $_GET['action'];

		$this->data['title'] = 'Content';

		if(isset($_POST) && !empty($_POST)){

			$page_id = $_POST['page_id'];
			$subto = $_POST['subto'];
			$content = $_POST['content'];
			$sort_order = $_POST['sort_order'];
			//$slug = Url::generateSafeSlug($pagename);

			$insert_array = array(
				'content_page_id'=>$page_id,
				'content_subto'=>$subto,
				'content_body'=>$content,
				'content_sort_order'=>$sort_order);

			$insert_id = $this->contentModel->create($insert_array);

			if($insert_id > 0){
				$message = 'ok';
			} else {
				$message = 'no';
			}

		}


			if($message == 'ok'){
				$this->data['success'] = 'Page Mapped!';
			} else if($message == 'no'){
				$this->data['error'] = 'Operation Fails!';
			}

		

		$this->data['pages'] = $this->pageModel->all();
		$this->data['pagecontent_data'] = $this->contentModel->find($insert_id);

		View::rendertemplate('home_header', $this->data);
		View::rendertemplate('sidebar', $this->data);
		View::render('pages/addcontent', $this->data);
		View::rendertemplate('footer', $this->data);
	} 


	public function allpages(){

		$total = count($this->pageModel->pages_contents_mainlink());


		$pages = new Paginator('5','p');
		$this->data['pages_contents'] = $this->pageModel->pages_contents($pages->getLimit());
		$pages->setTotal($total);
		$path = DIR.'page/allpages?';  
		$this->data['page_links'] = $pages->pageLinks($path,null);


		View::rendertemplate('header', $this->data);
		View::rendertemplate('sidebar', $this->data);
		View::render('pages/allpages', $this->data);
		View::rendertemplate('footer', $this->data);
	}



	public function allpagesedit($param){
		$page_rowid = $param[0];

		$this->data['title'] = 'Edit Content';

		if(isset($_POST) && !empty($_POST)){
			$subto = $_POST['subto'];
			$plugin = $_POST['plugin'];
			$content = $_POST['content'];
			$homepage = $_POST['homepage'];
			$header_menu = $_POST['header_menu'];
			$footer_menu = $_POST['footer_menu'];
			$redirecturl = $_POST['redirecturl'];
			$album = $_POST['album'];
			$meta_keywords = $_POST['meta_keywords'];
			$meta_title = $_POST['meta_title'];
			$meta_description = $_POST['meta_description'];
			$sort_order = $_POST['sort_order'];
			//$slug = Url::generateSafeSlug($pagename);

			$update_array = array(
				'content_plugin'=>$plugin,
				'content_subto'=>$subto,
				'content_excerpt'=>$_POST['excerpt'],
				'content_body'=>$_POST['content'],
				'content_homepage'=>$homepage,
				'content_header_menu'=>$header_menu,
				'content_footer_menu'=>$footer_menu,
				'content_redirecturl'=>$redirecturl,
				'content_album'=>$album,
				'content_meta_keywords'=>$meta_keywords,
				'content_meta_title'=>$meta_title,
				'content_meta_description'=>$meta_description,
				'content_sort_order'=>$sort_order);

			$where_array = array('content_id'=>$page_rowid);

			// $update_array = Gump::xss_clean($update_array);
			// $update_array = Gump::sanitize($update_array);

			$update = $this->contentModel->update($update_array, $where_array);


					if($_FILES["image1_extra"]["tmp_name"] != '')
						{
							//upload image into uploads folder
							Upload::setName($slug.uniqid());
							Upload::upload_file($_FILES["image1_extra"],UPLOAD_PATH);
							
							$image_name = Upload::getFileName('images');
							$update_data = array('content_banner' => $image_name);
							
							$update = $this->contentModel->update($update_data, $where_array);
						}

						if($_FILES["image2_extra"]["tmp_name"] != '')
						{
							//upload image into uploads folder
							Upload::setName($slug.uniqid());
							Upload::upload_file($_FILES["image2_extra"],UPLOAD_PATH);
							
							$image_name = Upload::getFileName('images');
							$update_data = array('content_thumbnail' => $image_name);

							$update = $this->contentModel->update($update_data, $where_array);
						}

						if($update > 0){
							$message = 'ok';
						} else {
							$message = 'no';
						}

		}


			if($message == 'ok'){
				Session::set('success',' Content Saved!');
			} else if($message == 'no'){
				Session::set('error','Operation Fails!');
			}

		$this->data['pages'] = $this->pageModel->all();
		$this->data['page_data'] = $this->contentModel->detail($page_rowid);
		// $this->data['pagecontent_data'] = $this->contentModel->find($insert_id);


		View::rendertemplate('header', $this->data);
		View::rendertemplate('sidebar', $this->data);
		View::render('pages/editcontent', $this->data);
		View::rendertemplate('footer', $this->data);

	}



}
