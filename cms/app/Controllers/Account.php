<?php 
namespace Controllers;

use Core\View;
use Core\Controller;

use Helpers\Url;
use Helpers\Session;
use Helpers\Auth;
use Helpers\PhpMailer\Mail;


use Models\User;


/*
 * Welcome controller
 *
 * @author David Carr - dave@daveismyname.com - http://www.daveismyname.com
 * @version 2.1
 * @date June 27, 2014
 */
class Account extends Controller{

	/**
	 * call the parent construct
	 */
	
	protected $user;

	public function __construct(){
		parent::__construct();
		
		// $this->user = new User;

		// $this->data['pagepath'] = Url::get_template_path();
		
		
	}

	/**
	 * define page title and load template files
	 */
	public function index(){	

		$data['title'] = 'Welcome';

		View::rendertemplate('header',$this->data);
		View::render('dashboard/dashboard.index',$this->data);
		View::rendertemplate('footer',$this->data);
	}


	public function login(){	
		Auth::redirect();


		if(isset($_POST) && !empty($_POST)){
			$user_model = new User;
		    $login = $user_model->login($_POST['email'],md5($_POST['password']));

		    if(!is_bool($login))
			{
					Session::set('user_id',$login->user_id);
					Session::set('user',$login);

					switch ($login->role_title) {
						case 'admin':
						Url::redirect('dashboard');
							break;

						// case 'business':
						// Url::redirect('user');
						// 	break;

						// case 'user1':
						// Url::redirect('user/dashboard');
						// 	break;

						
						default:
							# code...
							break;
					}

			} else {
				$this->data['error'] = 'Login Fails!';
			}
		}
		$this->data['title'] = 'Sign In';
		

		// View::rendertemplate('header',$this->data);
		View::render('account/login',$this->data);
		// View::rendertemplate('footer',$this->data);
	}


	public function forgotpassword(){	

		$this->data['title'] = 'Forgot Password';
		
		if(isset($_POST) && !empty($_POST)){
			$user = new User;
			$hash = new \Models\Hash;
			$user_details = $user->get_row(array('email'=>$_POST['email']));

			if($user_details->email != ''){
				//SEND ACCOUNT DETAILS TO USER
				$fullname = $user_details->firstname.' '.$user_details->lastname;
				$subject = 'Reset Password';
				$uniqid = uniqid();
				$insert_hash = $hash->create(array('user_id'=>$user_details->id,'hash'=>$uniqid,'status'=>'active'));
				$hash = DIR.'account/resetpassword/'.$uniqid;
				
				$mail = new Mail;
				$mail->template('forgotpassword');
				$mail->password($user_details->email,$subject,$fullname,$hash);
				$this->data['success'] = "A reset link has been sent to your email!"."<br> Click on link to reset.";

			} else {
				$this->data['error'] = 'This email does not exist in our records!';
			}
		}

		View::rendertemplate('header',$this->data);
		View::render('account/forgotpassword',$this->data);
		View::rendertemplate('footer',$this->data);
	}


	public function resetpassword($param){
		$slug = $param[0];
		$hash = new \models\hash;
		$user = new User;

		$this->data['title'] = 'Reset Password';

		$row = $hash->get_row(array('hash'=>$slug));

		if($row->status == 'active')
		{
				$user_id = $row->user_id;
				$this->data['userDetails'] = $user->find($user_id);			
		
				if(isset($_POST) && !empty($_POST)){
					$user_details = $user->get_row(array('email'=>$_POST['email']));

					if($_POST['password'] == $_POST['password2']){
						//UPDATE USER  PASSWORD
						$user->update(array("password"=>md5($_POST['password'])), array("id"=>$user_id));

						$this->data['success'] = "Password reset successful!.";

					} else {
						$this->data['error'] = 'This email does not exist in our records!';
					}
				}
		} else {
			$this->data['error'] = 'Reset record not found!';
		}

		View::rendertemplate('header',$this->data);
		View::render('account/resetpassword',$this->data);
		View::rendertemplate('footer',$this->data);
	}



	public function logout(){	

		Session::destroy('user');
		Session::destroy('user_id');
		Url::redirect('account/login');

	}



	public function signup($slug = null){
		$this->data['title'] = 'Join Us';

		// $module_slug = $slug[0];

		$role = new \models\userrole;
		$user = new User;

		$this->data['user_role'] = $role->all();

		//PULL DATA FROM SITESETTINGS
		$document = new \Helpers\Document; 
		$details = $document->siteSettings();

		//GET NEW USER STATUS ID
		$this->model->table('user_status');
		$user_status = $this->model->get_row(array("title"=>"inactive"));

		$this->data['reg_form'] = $details['reg_form'];

		if (isset($_POST) && !empty($_POST))
				{
					if($_POST['password'] == $_POST['password2']){
						$encrypted = md5($_POST['password']);


					$row_count = $user->get(array("email"=>$_POST['email']));
						if (count($row_count) >= 1) {
							$this->data['error'] = 'Email exists in our records, please use a different email';	
						} else {
							$insert_array = array(
								'firstname'=>$_POST['fname'],
								'lastname'=>$_POST['lname'],
								'email'=>$_POST['email'],
								'password'=>$encrypted,
								'role'=>$_POST['role'],
								'status'=>$user_status->id
								);

							$hash = $user->register($insert_array);
							if($hash != ''){
								//SEND ACCOUNT DETAILS TO USER
								$fullname = $_POST['fname'].' '.$_POST['lname'];
								$subject = 'New Account';
								
								$mail = new \helpers\phpmailer\mail;
								$mail->template('welcome');
								$mail->generalEmail($_POST['email'],$subject,$fullname,$hash);
								$this->data['success'] = 'A link has been sent to your email, please click to activate your account';
							}
							else
								$this->data['error'] = 'Operation Fails, Please contact admin';

						}

					} else 
						$this->data['error'] = 'Password does not match!';
				}		 

		View::rendertemplate('header',$this->data);
		View::render('account/signup',$this->data);
		View::rendertemplate('footer',$this->data);
	}
	
	
}