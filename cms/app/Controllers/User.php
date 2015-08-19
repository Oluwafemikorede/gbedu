<?php 
namespace Controllers;

use Core\View;
use Core\Controller;


class User extends Controller{

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

		$this->data['title'] = 'Yimu Admin';

		// $course = new \models\courses;
		$user_model = new \models\user;

		// $total = $user_model->allUsers();
		$total = count($user_model->allUsers());	
		

		$pages = new \helpers\paginator('10','p');
		$this->data['users'] = $user_model->allUsers($pages->get_limit());
		$pages->set_total($total);
		$path = DIR.'dashboard/users?';  
		$this->data['page_links'] = $pages->page_links($path,null);

		$this->data['title'] = 'Users';

	

		View::rendertemplate('header', $this->data);
		View::rendertemplate('sidebar', $this->data);
		View::render('user/user.index', $this->data);
		View::rendertemplate('footer', $this->data);
	} 


	public function add(){

		$user_model = new \models\user;
		$user_roles = new \models\roles;

		// $this->data['groups'] = $user->userByrole('group');
		$this->data['user_roles'] = $user_roles->all();


		if(isset($_POST) && !empty($_POST)){

			$fname = $_POST['fname'];
			$lname = $_POST['lname'];
			$gender = $_POST['gender'];
			$email = $_POST['email'];
			$phone = $_POST['phone'];
			$password = md5('123');
			
			$role = $_POST['role'];
			

			if($groupid == '' ){
				$groupid = 0;
			}
			
			
			$insert_array = array(
				'firstname'=>$fname,
				'lastname'=>$lname,
				// 'gender'=>$gender,
				'email'=>$email,
				'phone'=>$phone,
				'password'=>$password,
				// 'institution'=>$institution,
				'role'=>$role);

			$insert_id = $user->create($insert_array);

			if($insert_id > 0){
				$this->data['success'] = 'User Added!';
			} else {
				$this->data['error'] = 'Operation Fails!';
			}

					//UPLOAD ATTACHMENT
					if($_FILES["image"]["tmp_name"] != '')
						{
							//upload image into uploads folder
							\helpers\upload::setName($slug.uniqid());
							\helpers\upload::upload_file($_FILES["image"],UPLOAD_PATH);
							
							$image_name = 'gallery/'.\helpers\upload::$filename;
							$update_data = array('image' => $image_name);
							$where_array = array('id'=>$insert_id);

							$user->update($update_data, $where_array);
						}


			//GET INSERTED ID
			$this->data['user_data'] = $user->find($insert_id);
		}


		
		View::rendertemplate('home_header', $this->data);
		View::rendertemplate('sidebar', $this->data);
		View::render('dashboard/adduser', $this->data);
		View::rendertemplate('footer', $this->data);
	}

	public function edituser($param){
		$edit_id = $param[0];

		$user = new \models\users;
		$user_roles = new \models\roles;

		$this->data['groups'] = $user->userByrole('group');
		$this->data['user_roles'] = $user_roles->all();


		if(isset($_POST) && !empty($_POST)){

			$fname = $_POST['fname'];
			$lname = $_POST['lname'];
			$gender = $_POST['gender'];
			$email = $_POST['email'];
			$phone = $_POST['phone'];
			$password = md5('pass');
			$institution = $_POST['institution'];
			$role = $_POST['role'];
			$groupid = $_POST['groupid'];

			if($groupid == '' ){
				$groupid = 0;
			}
			
			
			$update_array = array(
				'firstname'=>$fname,
				'lastname'=>$lname,
				// 'gender'=>$gender,
				'email'=>$email,
				'phone'=>$phone,
				'password'=>$password,
				'institution'=>$institution,
				'role'=>$role,
				'groupid'=>$groupid);

			$where_array = array('id'=>$edit_id);

			$update_id = $user->update($update_array,$where_array);

			if($update_id > 0){
				$this->data['success'] = 'User Edited!';
			} else {
				$this->data['error'] = 'Operation Fails!';
			}

					//UPLOAD ATTACHMENT
					if($_FILES["image"]["tmp_name"] != '')
						{
							//upload image into uploads folder
							\helpers\upload::setName(uniqid());
							\helpers\upload::upload_file($_FILES["image"],UPLOAD_PATH);
							
							$image_name = 'gallery/'.\helpers\upload::$filename;
							$update_data = array('image' => $image_name);

							$user->update($update_data, $where_array);
						}


			//GET INSERTED ID
			
		}

		$this->data['user_data'] = $user->find($edit_id);

		
		View::rendertemplate('home_header', $this->data);
		View::rendertemplate('sidebar', $this->data);
		View::render('dashboard/adduser', $this->data);
		View::rendertemplate('footer', $this->data);
	}

}
