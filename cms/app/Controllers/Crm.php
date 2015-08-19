<?php 
namespace Controllers;

use Core\View;
use Core\Controller;

/*
 * Welcome controller
 *
 * @author David Carr - dave@daveismyname.com - http://www.daveismyname.com
 * @version 2.1
 * @date June 27, 2014
 */
class Crm extends Controller{

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
			$action = $_GET['action'];
		// var_dump($_GET['action']);

		$this->data['title'] = 'All Pages';

		$page = new \models\pages;
		$pagecategory = new \models\pagecategory;

		if(isset($_POST) && !empty($_POST)){

			$pagename = $_POST['pagename'];
			$category = $_POST['category'];
			$sort_order = $_POST['sort_order'];
			$slug = \helpers\url::generateSafeSlug($pagename);

			$insert_array = array(
				'pagename'=>$pagename,
				'categoryid'=>$category,
				'sort_order'=>$sort_order,
				'page_alias'=>$slug);

			$insert_id = $page->create($insert_array);

			if($insert_id > 0){
				$message = 'ok';
			} else {
				$message = 'no';
			}

		}


		if(isset($action) && !empty($action)){
			switch ($action) {
				case 'delete':
					$where_array = array('id'=>$_GET['id']);
					$delete = $page->delete($where_array);

					if($delete > 0)
						$message = 'ok';
					else
						$message = 'no';
					break;
				
				default:
					# code...
					break;
			}
		}


			if($message == 'ok'){
				$this->data['success'] = 'Record Added!';
			} else if($message == 'no'){
				$this->data['error'] = 'Operation Fails!';
			}

		

		$this->data['pages'] = $page->allPages();
		$this->data['page_categories'] = $pagecategory->all();

		View::rendertemplate('home_header', $this->data);
		View::rendertemplate('sidebar', $this->data);
		View::render('pages/pages.index', $this->data);
		View::rendertemplate('footer', $this->data);
	} 



	public function sms($param){
		$action = $_GET['action'];
		$sms_model = new \models\newsletter;
		$user_model = new \models\users;


		$this->data['subscribers'] = $sms_model->byGroup();

		$this->data['title'] = 'SMS';

		
		if(isset($_POST) && !empty($_POST)){

			$group = $_POST['subscribers'];
			$message = $_POST['content'];
			$sender = 'TheWorkCourt';
			
			$subscribers = $sms_model->get(array('group'=>$group));

			foreach($subscribers as $item){
				$send = \helpers\document::sendSMS($sender, $item->phone, $message);
			}
					
			$this->data['success'] = 'Mails Sent!';

			
		}



		View::rendertemplate('home_header', $this->data);
		View::rendertemplate('sidebar', $this->data);
		View::render('crm/sms', $this->data);
		View::rendertemplate('footer', $this->data);
	} 


	public function newsletter(){
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
