<?php 
namespace Controllers;

use Core\View;
use Core\Controller;

use Helpers\Session;
use Helpers\Paginator;
use Helpers\PhpMailer\Mail;
use Helpers\Document;
use Helpers\Url;
use Helpers\Gump;
use Helpers\Auth;

use Models\User;
use Models\Status;
use Models\Role;
use Models\Song;
use Models\Album;
/*
 * Welcome controller
 *
 * @author David Carr - dave@daveismyname.com - http://www.daveismyname.com
 * @version 2.1
 * @date June 27, 2014
 */
class Board extends Controller{


	// public $user_model;
	// public $hash_model;
	// public $album_model;
	// public $albumitem_model;
	// public $category_model;
	// public $role_model;
	// public $status_model;

	/**
	 * Call the parent construct
	 */
	public function __construct(){
		parent::__construct();
		Auth::block();

	}


	public function index(){
		$this->data['title'] = 'Workspace';

		$user_id = Session::get('user')->user_id;

		// $this->data['profile'] = $user_model->find($user_id);

		
		// var_dump($user_dance_category);
	

		View::rendertemplate('header',$this->data);
		View::render('dashboard/dashboard.index',$this->data);
		View::rendertemplate('footer',$this->data);
	}

	public function editprofile(){
		$this->data['title'] = 'Edit Profile';
		$user_model = new \Models\User;

		$this->data['user'] = Session::get('user');
		$this->data['user'] = $user_model->find(Session::get('user')->user_id);


		if(isset($_POST['user_firstname']) && !empty($_POST['user_firstname'])){

			if(count($_POST['dance_category']) > 3 ){
				$this->data['error'] = 'Dance category cannot exceed 3, Please correct';
			} else {


			$user_firstname  = $_POST['user_firstname'];
			$user_lastname  = $_POST['user_lastname'];
			$user_email  = $_POST['user_email'];
			$user_phone  = $_POST['user_phone'];
			$user_gender  = $_POST['user_gender'];
			$user_bio  = $_POST['user_bio'];
			$dance_category  = $_POST['dance_category'];
			$user_slug = Url::generateSafeSlug($user_firstname.$this->data['user']->user_id.$user_lastname);

			//delete all user's dancer's category first
			$delete = $userdance_model->delete(array('user_dance_user_id' => $this->data['user']->user_id),5);




			//insert dance category
			if(count($_POST['dance_category']) > 0 ){
					foreach ($dance_category as $value) {
						$dance_category_count = 0;
						$insert_dance_category = $userdance_model->create(
						array('user_dance_user_id'=>$this->data['user']->user_id,
							  'user_dance_category_id'=>$value));
						$dance_category_count++;
					}
				}

			//update user db
			$update_array = array(
					'user_firstname'=>$user_firstname,
					'user_lastname'=>$user_lastname,
					'user_email'=>$user_email,
					'user_bio'=>$user_bio,
					'user_gender'=>$user_gender,
					'user_slug'=>$user_slug,
					'user_phone'=>$user_phone);

				$update_array = Gump::xss_clean($update_array);
				$update_array = Gump::sanitize($update_array);

				$update_id = $user_model->updateId($update_array,$this->data['user']->user_id);

				

						//UPLOAD ATTACHMENT
						if($_FILES["image"]["tmp_name"] != '')
							{
								//upload image into uploads folder
								Upload::setName($slug.uniqid());
								Upload::resizeUpload($_FILES["image"],UPLOAD_PATH, '480px');
								
								$image_name = Upload::getFileName('images');
								$update_data = array('user_image' => $image_name);

								$update_img = $this->user_model->updateId($update_data, $this->data['user']->user_id);
								
								if($update_img > 0){
									Session::set('success','Profile Updated!');
									Url::redirect('user');
								} else {
									$this->data['error'] = 'Operation Fails!';
								}

							}

				if($update_id > 0){
					Session::set('success','Profile Updated!');
					Url::redirect('user');
				} else {
					$this->data['error'] = 'Operation Fails!';
				}

				if(isset($dance_category_count) && $dance_category_count > 0){
					Session::set('success','Dance Category Updated!');
					Url::redirect('user');
				} else {
					$this->data['error'] = 'Operation Fails!';
				}

			}

		}

		$this->data['dance_category'] = \models\category::section('dance');
		$user_dance_category = \models\userdance::category($this->data['user']->user_id);

		foreach($user_dance_category as $item){
			$this->data['user_dance_category'][] = $item->category_id;
		}



		View::rendertemplate('header',$this->data);
		View::render('workspace/workspace.editprofile',$this->data);
		View::rendertemplate('footer',$this->data);	
	}


	public function password(){
		$this->data['title'] = 'Change Password';
		$userModel = new User;
		$user_id = Session::get('user')->user_id;

		$user_details = $userModel->get(array('user_id'=>$user_id,
											'user_password'=>md5($_POST['old_password'])
													)
												);


		if(isset($_POST['password1']) && !empty($_POST['password1'])){

				if(count($user_details) > 0){

						if($_POST['password1'] == $_POST['password2']){
								//update user db
								$update_array = array('user_password'=>md5($_POST['password1']));
								$update_array = Gump::xss_clean($update_array);
								$update_array = Gump::sanitize($update_array);

								$update_id = $user_model->updateId($update_array,$user_id);
									
								if($update_id > 0){
									Session::set('success','Password Changed');
								} else 
									Session::set('error','Operation Fails!');
								

						} else {
							Session::set('error','Incorrect match, password change fails!');
						}

				} else {
					Session::set('error','Incorrect match, password change fails!');
				}
			}


		View::rendertemplate('header',$this->data);
		View::render('workspace/workspace.password',$this->data);
		View::rendertemplate('footer',$this->data);	
	}

	public function deleteitem($parameter){
		$media_type = $parameter[0];
		$item_id = $parameter[1];

		$model = new \models\albumitem;
		$delete = $model->deleteId($item_id);

		if($delete > 0)
			Session::set('success','record deleted!');
		else
			Session::set('error','unable to delete record!');

			// hea
			Url::redirect('workspace/'.$media_type);
			// header('Location: '. $_SERVER['HTTP_REFERER']);
        exit;
	}



	
}
