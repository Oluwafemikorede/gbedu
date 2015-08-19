<?php 
namespace Controllers;

use Core\View;
use Core\Controller;

use Helpers\Session;
use Helpers\Url;
use Helpers\Gump;
use Helpers\Auth;
use Helpers\PhpMailer\Mail;
use Helpers\Document;

use Models\User;
use Models\Status;
use Models\Role;

/*
 * Welcome controller
 *
 * @author David Carr - dave@daveismyname.com - http://www.daveismyname.com
 * @version 2.1
 * @date June 27, 2014
 */
class Account extends Controller{


	public $fb;

	/**
	 * Call the parent construct
	 */
	public function __construct(){
		parent::__construct();

		$this->fb = new \Facebook\Facebook([
		  'app_id' => APP_ID,
		  'app_secret' => APP_SECRET,
		  'default_graph_version' => 'v2.2',
		  ]);

	}

	public function signin(){	

		$userModel   = new \Models\User;


		$helper = $this->fb->getRedirectLoginHelper();
		$permissions = ['email', 'user_likes']; // optional
		$callback_url = DIR.'account/fblogin';
		$this->data['loginUrl'] = $helper->getLoginUrl($callback_url, $permissions);

		if(isset($_POST['email']) && !empty($_POST['email'])){
		    $login = $userModel->login($_POST['email'],md5($_POST['password']));

		    if(!is_bool($login))
			{
					Session::set('user_id',$login->user_id);
					Session::set('user',$login);

					//redirects user to last visited page
					$redirectUrl = Session::get('redirectLogin');
					Session::destroy('redirectLogin');
					if(isset($redirectUrl) && $redirectUrl != '')
						Url::redirect($redirectUrl);
					else
						Url::redirect('board');

			} else {
				Session::set('error','Login Fails!');
			}
		}
		$this->data['title'] = 'Sign In';

		View::rendertemplate('header',$this->data);
		View::render('account/signin',$this->data);
		View::rendertemplate('footer',$this->data);
	}

	public function fblogin(){

					$helper = $this->fb->getRedirectLoginHelper();

					try {

					  $accessToken = $helper->getAccessToken();
					  $response    = $this->fb->get('/me?fields=email,name', $accessToken);

					} catch(\Facebook\Exceptions\FacebookResponseException $e) {
					  // When Graph returns an error
					  echo 'Graph returned an error: ' . $e->getMessage();
					  exit;
					} catch(\Facebook\Exceptions\FacebookSDKException $e) {
					  // When validation fails or other local issues
					  echo 'Facebook SDK returned an error: ' . $e->getMessage();
					  exit;
					}

					if (! isset($accessToken)) {
					  if ($helper->getError()) {
					    header('HTTP/1.0 401 Unauthorized');
					    echo "Error: " . $helper->getError() . "\n";
					    echo "Error Code: " . $helper->getErrorCode() . "\n";
					    echo "Error Reason: " . $helper->getErrorReason() . "\n";
					    echo "Error Description: " . $helper->getErrorDescription() . "\n";
					  } else {
					    header('HTTP/1.0 400 Bad Request');
					    echo 'Bad request';
					  }
					  exit;
					}

					// Logged in
					echo '<h3>Access Token</h3>';
					var_dump($accessToken->getValue());

					// The OAuth 2.0 client handler helps us manage access tokens
					$oAuth2Client = $this->fb->getOAuth2Client();

					// Get the access token metadata from /debug_token
					$tokenMetadata = $oAuth2Client->debugToken($accessToken);
					echo '<h3>Metadata</h3>';
					var_dump($tokenMetadata);

					// Validation (these will throw FacebookSDKException's when they fail)

					// $tokenMetadata->validateAppId($config['app_id']);

					$tokenMetadata->validateAppId(APP_ID);

					// If you know the user ID this access token belongs to, you can validate it here
					//$tokenMetadata->validateUserId('123');
					$tokenMetadata->validateExpiration();

					if (! $accessToken->isLongLived()) {
					  // Exchanges a short-lived access token for a long-lived one
					  try {
					    $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
					  } catch (\Facebook\Exceptions\FacebookSDKException $e) {
					    echo "<p>Error getting long-lived access token: " . $helper->getMessage() . "</p>\n\n";
					    exit;
					  }

					  echo '<h3>Long-lived</h3>';
					  var_dump($accessToken->getValue());
					}


					$user 	= $response->getGraphUser();
					$email  = $user['email'];
					$name   = $user['name'];



					//check if user has been registered
					$user_rec = $this->user_model->getColRow('user_email',$email);

					// var_dump($user_rec->user_email);

					if(!is_bool($user_rec) && $user_rec->user_email != NULL){
						//email is registered
						Session::set('user_id',$user_rec->user_id);
						Session::set('user',$user_rec);
					} else {
						$insert_array = array('user_email'=>$user['email'],
											  'user_firstname'=>$user['name']);

						$insert_id = $this->user_model->create($insert_array);

						if($insert_id > 0){
							$new_user = $this->user_model->find($insert_id);
							Session::set('user_id', $new_user->user_id);
							Session::set('user', $new_user);
						}
					}

					$_SESSION['fb_access_token'] = (string) $accessToken;

					Url::redirect('user');

					// var_dump(Session::get('user_id'));
					// echo 'Name: ' . $user['name'];

	}

	// public function socialFb(){	
		
	// 	$helper = $this->fb->getRedirectLoginHelper();
	// 	$permissions = ['email', 'user_likes']; // optional
	// 	$callback_url = DIR.'account/socialin';
	// 	$this->data['loginUrl'] = $helper->getLoginUrl($callback_url, $permissions);
	// 	$loginUrl = $helper->getLoginUrl($callback_url, $permissions);

	// 	echo '<a href="' . $loginUrl . '">Log in with Facebook!</a>';


	// }


	public function forgotpassword(){	

		$this->data['title'] = 'Retrieve Password';
		$hash_model = new \models\hash;
		
		if(isset($_POST['email']) && !empty($_POST['email'])){
			$user_details = $this->user_model->getColRow('user_email',$_POST['email']);

			if($user_details->user_email != ''){
			$get_status = $this->status_model->getColRow('status_title','active');


			$uniqid = uniqid();

			$insert = $hash_model->create(array('hash_user_id'=>$user_details->user_id,
												'hash_value'=>$uniqid,
												'hash_status_id'=>$get_status->status_id));



				//SEND ACCOUNT DETAILS TO USER
				$fullname = $user_details->user_firstname.' '.$user_details->user_lastname;
				$subject = 'Reset Password';
				$content .= "You have requested for a new password, please click the link below to reset";
				$content .= '<a href="'.DIR.'account/resetpassword/'.$uniqid.'" target="_blank">Get Password </a>';
				
				$mail = new \helpers\phpmailer\mail;
				$mail->general($user_details->user_email, $subject, $fullname, $content);


				$this->data['success'] = "Congrats!, A reset link has been sent to your email";

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

		$this->data['title'] = 'Set Password';

		$row = $this->hash_model->check($slug);

		if(!is_bool($row))
		{
				$user_id = $row->user_id;
				$this->data['userDetails'] = $this->user_model->find($user_id);			
		
				if(isset($_POST['password']) && !empty($_POST['password'])){
					$user_details = $this->user_model->get_row(array('user_email'=>$_POST['email']));

					if($_POST['password'] == $_POST['password2']){
						//UPDATE USER  PASSWORD
						$this->user_model->update(array("user_password"=>md5($_POST['password'])), 
												  array("user_id"=>$user_id));

						$this->data['success'] = "Password reset successful!";

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
		Url::redirect('account/signin');

	}


	public function signup($slug = null){
		$this->data['title'] = 'Join Us';

		$statusModel = new Status;
		$roleModel = new Role;
		$userModel = new User;

		if (isset($_POST['email']) && !empty($_POST['email']))
				{

					$firstname = $_POST['firstname'];
					$email = $_POST['email'];

					if($_POST['password'] == $_POST['password2']){
						$encrypted = md5($_POST['password']);

						$row_count = $userModel->getColRow('user_email',$email);

						if(!is_bool($row_count)) {
							Session::set('error', 'Email exists in our records, please use a different email');	
						} else {
							$userArray = array(
								'user_firstname'=>$firstname,
								'user_email'=>$email,
								'user_password'=>$encrypted,
								'user_role_id'=>Role::id('user'),
								'user_status_id'=>Status::id('active')
								);

							$userArray = Gump::xss_clean($userArray);
							$userArray = Gump::sanitize($userArray);

							$is_valid = Gump::is_valid($userArray, array(
							    'user_firstname' => 'required|max_len,200|min_len,1',
							    'user_email'     => 'required|max_len,200|min_len,1',
							    'user_password'  => 'required|max_len,200|min_len,1'
							));


							if($is_valid === true) {
								$user_id = $userModel->create($userArray);

								if($user_id > 0){
								$slug = Url::generateSafeSlug($firstname.$user_id);

								//send email
								$subject = 'Welcome to GbeduMobile';
								$content .= "You just opened a new account with us, Get login details below<br><br>";
								$content .= "Username: ".$email."<br>";
								$content .= "Password: ".$_POST['password']."<br>";

								if(ENVIRONMENT == 'production'){
									$mail = new Mail;
									$mail->general($email, $subject, $firstname, $content);
								}

								Session::set('success','Login details has been sent to your email, Congrats!');
								Url::redirect('home');

							} else
								Session::set('error', 'Operation Fails, Please contact admin');
							} else{
								Session::set('error', $is_valid);
							}

						}

					} else 
						Session::set('error', 'Password does not match!');
				}		 

		View::rendertemplate('header',$this->data);
		View::render('account/signup',$this->data);
		View::rendertemplate('footer',$this->data);
	}

	
}
