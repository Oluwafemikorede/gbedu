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

use Models\Post as PostModel;
use Models\User;
use Models\Category;
use Models\Album;
use Core\Controller;

/*
 * Welcome controller
 *
 * @author David Carr - dave@daveismyname.com - http://www.daveismyname.com
 * @version 2.1
 * @date June 27, 2014
 */
class Post extends Controller{

	/**
	 * call the parent construct
	 */
	public function __construct(){
		Auth::block();
		
		parent::__construct();

		// $this->language->load('welcome');
	}

	/**
	 * define page title and load template files
	 */
	public function index($category_title, $category_slug){
		
		$this->data['title'] = 'Manage Posts';


		$total = count(PostModel::category($category_title, $category_slug));

		$pages = new Paginator('4','p');
		$this->data['post_content'] = PostModel::category($category_title, $category_slug, $pages->getLimit());
		$pages->setTotal($total);
		$path = DIR.'post/'.$category_title.'/'.$category_slug.'?';  
		$this->data['page_links'] = $pages->pageLinks($path,null);

		View::rendertemplate('header', $this->data);
		View::rendertemplate('sidebar', $this->data);
		View::render('post/post.index', $this->data);
		View::rendertemplate('footer', $this->data);
	} 



	public function add($parameter){
		$category_slug = $parameter[0];

		$this->data['title'] = 'Add Post';

		$category_model = new Category;
		$post_model = new \Models\Post;
		$album_model = new Album;

		$this->data['album_group'] = $album_model->all();
		$this->data['post_category'] = $category_model->getCol('category_slug',$category_slug);

		// var_dump(count($this->data['post_category']));

		if(isset($_POST) && !empty($_POST)){
			$post_user_id = Session::get('user_id');
			$post_category_id = $_POST['post_category_id'];
			$post_album_id = $_POST['post_album_id'];
			$post_title = $_POST['post_title'];
			$post_body = $_POST['post_body'];
			$post_link = $_POST['post_link'];
			$post_excerpt = $_POST['post_excerpt'];
			$post_slug = Url::generateSafeSlug($post_title);
			$post_created  = time();

			$post_array = array(
				'post_user_id'=>$post_user_id,
				'post_category_id'=>$post_category_id,
				'post_album_id'=>$post_album_id,
				'post_title'=>$post_title,
				'post_body'=>$post_body,
				'post_link'=>$post_link,
				'post_excerpt'=>$post_excerpt,
				'post_slug'=>$post_slug,
				'post_created'=>$post_created
				);

			// $insert_array = Gump::xss_clean($insert_array);
			// $insert_array = Gump::sanitize($insert_array);

			$post_id = $post_model->create($post_array);


			//UPLOAD IMAGE
			if($_FILES["image"]["tmp_name"] != '')
				{
					Upload::setName(uniqid());
					Upload::upload_file($_FILES["image"],UPLOAD_PATH);
					
					$update_data = array('post_image' => Upload::getFileName('images'));
					
					$update = $post_model->updateId($update_data, $post_id);
				}



			if($insert_post_id > 0){
				Session::set('success','post added');
				Url::redirect('post');
			}
		}

		View::rendertemplate('header', $this->data);
		View::rendertemplate('sidebar', $this->data);
		View::render('post/post.add', $this->data);
		View::rendertemplate('footer', $this->data);

	}


	public function edit($parameter){
		$item_id = $parameter[0];

		$this->data['title'] = 'Edit Post';

		$category_model = new \Models\Category;
		$post_model = new \Models\Post;
		$album_model = new \models\album;

		$this->data['post'] = $post_model->getItem($item_id);

		$this->data['album_group'] = $album_model->all();
		$this->data['post_category_groups'] = $category_model->groupByCol('category_slug');

		if(isset($_POST) && !empty($_POST)){
			$post_category_id = $_POST['post_category_id'];
			$post_album_id = $_POST['post_album_id'];
			$post_title = $_POST['post_title'];
			$post_body = $_POST['post_body'];
			$post_link = $_POST['post_link'];
			$post_excerpt = $_POST['post_excerpt'];
			$post_slug = Url::generateSafeSlug($post_title);
			$post_modified  = time();

			$update_array = array(
				// 'post_user_id'=>$post_user_id,
				'post_category_id'=>$post_category_id,
				'post_album_id'=>$post_album_id,
				'post_title'=>$post_title,
				'post_body'=>$post_body,
				'post_link'=>$post_link,
				'post_excerpt'=>$post_excerpt,
				'post_slug'=>$post_slug,
				'post_modified'=>$post_modified
				);

			$update_array = Gump::xss_clean($update_array);

			$update_array = Gump::sanitize($update_array);

			$update_id = $post_model->updateId($update_array, $item_id);


			//UPLOAD IMAGE
			if($_FILES["image"]["tmp_name"] != '')
				{
					Upload::setName(uniqid());
					Upload::upload_file($_FILES["image"],UPLOAD_PATH);
					
					$image_name  = Upload::getFileName('images');
					$update_data = array('post_image' => $image_name);
					
					$update = $post_model->updateId($update_data, $update_id);
				}


			if($update_id > 0){
				Session::set('success','post edited');
				Url::redirect('post');
			}
		}

		View::rendertemplate('header', $this->data);
		View::rendertemplate('sidebar', $this->data);
		View::render('post/post.add', $this->data);
		View::rendertemplate('footer', $this->data);

	}

	public function delete($parameter){
		$item_id = $parameter[0];

		$post_model = new \models\post;

		$delete = $post_model->deleteId($item_id);

		if(isset($delete)){
			Session::set('success','record deleted');
			Url::previous();
		}

	}



}
