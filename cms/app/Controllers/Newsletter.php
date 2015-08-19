<?php 

namespace Controllers;

use Core\View;
use Core\Controller;

/*
 * Welcome controller
 * @author David Carr - dave@daveismyname.com - http://www.daveismyname.com
 * @version 2.1
 * @date June 27, 2014
 */
class Newsletter extends Controller{

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


	public function page(){
		$action = $_GET['action'];

		//INITIALIZE MODEL
		$newsletterpage_model = new \models\newsletterpage;

		$this->data['title'] = 'Newsletter Page';

		if(isset($action) && !empty($action)){
			switch ($action) {
				case 'delete':
					$where_array = array('id'=>$_GET['id']);
					$delete = $newsletterpage_model->delete($where_array);

					if($delete > 0)
						$this->data['success'] = 'Record Deleted!';
					else
						$this->data['error'] = 'Operation Fails!';
					break;
				
				default:
					break;
			}
		}
		

		$this->data['pages'] = $newsletterpage_model->all();

		View::rendertemplate('home_header', $this->data);
		View::rendertemplate('sidebar', $this->data);
		View::render('newsletter/newsletter.page', $this->data);
		View::rendertemplate('footer', $this->data);
	}

	public function createpage(){
		$action = $_GET['action'];

		//INITIALIZE MODEL
		$newsletterpage_model = new \models\newsletterpage;

		$this->data['title'] = 'Newsletter Page';

		if(isset($_POST) && !empty($_POST)){
			//PAGE DATA
			$author = $_POST['author'];
			$title = $_POST['title'];
			$content = $_POST['content'];
			$meta_keywords = $_POST['meta_keywords'];
			$meta_title = $_POST['meta_title'];
			$meta_description = $_POST['meta_description'];
			$sort_order = $_POST['sort_order'];

			$slug = \helpers\url::generateSafeSlug($title);

			$insert_array = array(
				'author'=>$author,'title'=>$title,
				'content'=>$content,'meta_keywords'=>$meta_keywords,
				'meta_title'=>$meta_title,'meta_description'=>$meta_description,
				'sort_order'=>$sort_order,'slug'=>$slug);

			$insert_page_id = $newsletterpage_model->create($insert_array);

					//UPLOAD IMAGE
					if($_FILES["image"]["tmp_name"] != '')
						{
							\helpers\upload::setName($slug.uniqid());
							\helpers\upload::upload_file($_FILES["image"],UPLOAD_PATH);
							
							$image_name = 'gallery/'.\helpers\upload::$filename;
							$update_data = array('image' => $image_name);
							$where_array = array('id'=>$insert_page_id);

							$update = $newsletterpage_model->update($update_data, $where_array);
						}


			if($insert_page_id > 0)
				$this->data['success'] = 'Page created!';
			else
				$this->data['error'] = 'Operation Fails!';


			$this->data['page_data'] = $newsletterpage_model->find($insert_page_id);

		}


		if(isset($action) && !empty($action)){
			switch ($action) {
				case 'delete':
					$where_array = array('id'=>$_GET['id']);
					$delete = $newsletterpage_model->delete($where_array);

					if($delete > 0)
						$this->data['success'] = 'Record Deleted!';
					else
						$this->data['error'] = 'Operation Fails!';
					break;
				
				default:
					break;
			}
		}
		

		$this->data['pages'] = $newsletterpage_model->all();

		View::rendertemplate('home_header', $this->data);
		View::rendertemplate('sidebar', $this->data);
		View::render('newsletter/newsletter.createpage', $this->data);
		View::rendertemplate('footer', $this->data);
	}



	public function pageedit($param){
		$edit_id = $param[0];

		//INITIALIZE MODEL
		$newsletterpage_model = new \models\newsletterpage;

		$this->data['title'] = 'Newsletter Page: Edit';

		if(isset($_POST) && !empty($_POST)){
			//PAGE DATA
			$author = $_POST['author'];
			$title = $_POST['title'];
			$content = $_POST['content'];
			$meta_keywords = $_POST['meta_keywords'];
			$meta_title = $_POST['meta_title'];
			$meta_description = $_POST['meta_description'];
			$sort_order = $_POST['sort_order'];


			$slug = \helpers\url::generateSafeSlug($title);

			$update_array = array(
				'author'=>$author,'title'=>$title,
				'content'=>$content,'meta_keywords'=>$meta_keywords,
				'meta_title'=>$meta_title,'meta_description'=>$meta_description,
				'sort_order'=>$sort_order,'slug'=>$slug);

			$where_array = array('id'=>$edit_id);

			$update_id = $newsletterpage_model->update($update_array, $where_array);

					//UPLOAD IMAGE
					if($_FILES["image"]["tmp_name"] != '')
						{
							\helpers\upload::setName($slug.uniqid());
							\helpers\upload::upload_file($_FILES["image"],UPLOAD_PATH);
							
							$image_name = 'gallery/'.\helpers\upload::$filename;
							$update_data = array('image' => $image_name);
							
							$update = $newsletterpage_model->update($update_data, $where_array);
						}

			if($update_id > 0)
				$this->data['success'] = 'page edited!';
			else
				$this->data['error'] = 'operation Fails!';

		}
		

		$this->data['page_data'] = $newsletterpage_model->find($edit_id);

		View::rendertemplate('home_header', $this->data);
		View::rendertemplate('sidebar', $this->data);
		View::render('newsletter/newsletter.pageedit', $this->data);
		View::rendertemplate('footer', $this->data);
	}

	public function send(){
		$action = $_GET['action'];
		$newsletter_model = new \models\newsletter;
		$user_model = new \models\users;


		$this->data['subscribers'] = $newsletter_model->byGroup();

		$this->data['title'] = 'Newsletter';

		
		if(isset($_POST) && !empty($_POST)){

			$group = $_POST['subscribers'];
			$content = $_POST['content'];
			$subject = $_POST['subject'];
			//$slug = \helpers\url::generateSafeSlug($pagename);

			$subscribers = $newsletter_model->get(array('group'=>$group));



			$mail_helper = new \helpers\phpmailer\mail;

			foreach($subscribers as $item){
				$mail_helper->template('newsletter');
				$mail_helper->newsletter($item->email,$subject,$content);
			}
					

				$this->data['success'] = 'Mails Sent!';
		}



		View::rendertemplate('home_header', $this->data);
		View::rendertemplate('sidebar', $this->data);
		View::render('crm/newsletter', $this->data);
		View::rendertemplate('footer', $this->data);
	}

}
