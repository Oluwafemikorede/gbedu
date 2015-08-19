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
use Helpers\Paginator;
use Helpers\PhpMailer\Mail;
use Helpers\Gump;
use Helpers\Cpanel\Cpmail;





class Artist extends Controller{

	/**
	 * call the parent construct
	 */
	protected $user_model;
	protected $role_model;
	protected $album_model;
	protected $status_model;

	public function __construct(){
		parent::__construct();

		$this->user_model   = new \Models\User;
		$this->album_model  = new \Models\Album;
		$this->role_model   = new \Models\Role;
		$this->status_model = new \Models\Status;
	}

	/**
	* define page title and load template files
	*/
	public function index(){

		$this->data['title'] = 'Artists';
		

		$total = count($this->user_model->artist());	

		$pages = new Paginator('10','p');
		$this->data['artist'] = $this->user_model->artist($pages->getLimit());
		$pages->setTotal($total);
		$path = DIR.'artist?';  
		$this->data['pageLinks'] = $pages->pageLinks($path,null);

		$this->data['title'] = 'Consultants';
	

		View::rendertemplate('header', $this->data);
		View::rendertemplate('sidebar', $this->data);
		View::render('artist/artist.index', $this->data);
		View::rendertemplate('footer', $this->data);
	} 


	public function delete($parameter){
			$user_id = $parameter[0];
			$user_model = new User;
			$delete = $user_model->deleteId($user_id);

			if($delete > 0){
				Session::set('success','record deleted!');
			} else {
				Session::set('error','delete fails!');
			}
				Url::previous();

	}


	public function status($parameter){
		$type = $parameter[0];
		$id   = $parameter[1];

		if($type == 'deactivate'){
			$update_user = $this->user_model->updateId(array('user_status_id'=>Status::id('inactive')), $id);
		} else {
			$update_user = $this->user_model->updateId(array('user_status_id'=>Status::id('active')), $id);
		}
					
			if(isset($update_user))
				Session::set('success', 'status changed!');
			else
				Session::set('error', 'operation fails');
		
		Url::previous();
	}



	public function add(){
		$user_model = new User;
		$album_model = new Album;
		$role_model = new Role;
		$status_model = new Status;


		$this->data['title'] = 'Add Artist';

		if(isset($_POST) && !empty($_POST)){

			$artistArray = array(
				'user_firstname'=>$_POST['firstname'],
				'user_stagename'=>$_POST['stagename'],
				'user_bio'	    =>$_POST['bio'],
				'twitter_handle'=>$_POST['twitter_handle'],
				'user_status_id'=>Status::id('active'),
				'user_role_id'	=>Role::id('artist'),
				'user_created'	=>time());


			$artistArray = Gump::xss_clean($artistArray);
			$artistArray = Gump::sanitize($artistArray);

			$artist_id = $user_model->create($artistArray);


			if($artist_id > 0){
				$this->data['success'] = 'Artist Added!';
				$slug = Url::generateSafeSlug($_POST['stagename'].$artist_id);
				$user_model->updateId(array('user_slug' => $slug), $artist_id);
			} else {
				$this->data['error'] = 'Operation Fails!';
			}


					//UPLOAD ATTACHMENT
					if($_FILES["image"]["tmp_name"] != '')
						{
							//upload image into uploads folder
							Upload::setName($slug.uniqid());
							Upload::resizeUpload($_FILES["image"],UPLOAD_PATH, '450px');
							
							$update_data = array('user_image' => Upload::getFileName('images'));

							$this->user_model->updateId($update_data, $artist_id);
						}

			//GET INSERTED ID
			$this->data['user_data'] = $user_model->find($insert_id);
			Url::redirect('artist');
		}

		
		View::rendertemplate('header', $this->data);
		View::rendertemplate('sidebar', $this->data);
		View::render('artist/artist.add', $this->data);
		View::rendertemplate('footer', $this->data);
	}

	public function edit($param){
		$edit_id = $param[0];

		$user_model = new User;

		if(isset($_POST) && !empty($_POST)){

			$artistArray = array(
				'user_firstname'=>$_POST['firstname'],
				'user_stagename'=>$_POST['stagename'],
				'user_bio'	    =>$_POST['bio'],
				'twitter_handle'=>$_POST['twitter_handle'],
				'user_modified' =>time());


				$artistArray = Gump::xss_clean($artistArray);
				$artistArray = Gump::sanitize($artistArray);


				$update_id = $user_model->updateId($artistArray, $edit_id);


				//UPLOAD ATTACHMENT
				if($_FILES["image"]["tmp_name"] != '')
					{
						//upload image into uploads folder
						Upload::setName($slug.time());
						Upload::resizeUpload($_FILES["image"],UPLOAD_PATH, '450px');
						
						$update_data = array('user_image' => Upload::getFileName('images'));

						if($this->user_model->updateId($update_data, $edit_id)){
							Session::set('success','Artist record edited');
						} else {
							Session::set('error','operation fails');
						}
					}


						if($update_id > 0){
							Session::set('success','Artist record edited');
							Url::redirect('artist');
						} else {
							Session::set('error','operation fails');
						}

		}

	

		$this->data['user_data'] = $user_model->find($edit_id);

		
		View::rendertemplate('header', $this->data);
		View::rendertemplate('sidebar', $this->data);
		View::render('artist/artist.add', $this->data);
		View::rendertemplate('footer', $this->data);
	}

}
