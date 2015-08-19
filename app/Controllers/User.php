<?php namespace controllers;
use core\view;

/*
 * Welcome controller
 *
 * @author David Carr - dave@daveismyname.com - http://www.daveismyname.com
 * @version 2.1
 * @date June 27, 2014
 */
class User extends \core\controller{


	public $user_model;
	public $hash_model;
	public $album_model;
	public $albumitem_model;
	public $category_model;
	public $role_model;
	public $status_model;

	/**
	 * Call the parent construct
	 */
	public function __construct(){
		parent::__construct();
		\helpers\auth::auth_block();

		$this->user_model = new \models\user;
		$this->hash_model = new \models\hash;
		$this->type_model = new \models\type;
		$this->album_model = new \models\album;
		$this->albumitem_model = new \models\albumitem;
		$this->category_model = new \models\category;
		$this->role_model = new \models\role;
		$this->status_model = new \models\status;

	}


	public function index(){
		$this->data['title'] = 'Dashboard';
		$user_model = new \models\user;
		$userdance_model = new \models\userdance;
		$like_model = new \models\like;

		$user_id = \helpers\session::get('user')->user_id;

		$this->data['profile'] = $user_model->find($user_id);

		$this->data['fb_likes'] = $like_model->getColRow('like_user_id',$user_id);
		$this->data['fb_position'] = \models\like::position($user_id);

		$this->data['dance_category'] = \models\category::section('dance');
		$user_dance_category = \models\userdance::category($user_id);

		// var_dump($user_dance_category);
		$i=0;
			foreach($user_dance_category as $item){
				if($i == 0)
					$this->data['user_dance_category'] = $item->category_title;
				else
					$this->data['user_dance_category'] .=', '.$item->category_title;
			$i++;
			}

		View::rendertemplate('header',$this->data);
		View::rendertemplate('mobile-menu', $this->data);
		View::render('user/user.dashboard',$this->data);
		View::rendertemplate('footer',$this->data);
	}

	public function video(){


		$this->data['title'] = 'Dashboard';
		$user = \helpers\session::get('user');

		$total = count(\models\albumitem::getUserMedia($user->user_album_id, 'video'));	

		$pages = new \helpers\paginator('10','p');
		$this->data['user_videos'] = \models\albumitem::getUserMedia($user->user_album_id, 'video',$pages->get_limit()); 
		$pages->set_total($total);
		$path = DIR.'user/video?';  
		$this->data['page_links'] = $pages->page_links($path,null);


		View::rendertemplate('header',$this->data);
		View::rendertemplate('mobile-menu', $this->data);
		View::render('user/user.video',$this->data);
		View::rendertemplate('footer',$this->data);
	}


	public function image(){
		$this->data['title'] = 'Dashboard';
		$user = \helpers\session::get('user');

		$total = count(\models\albumitem::getUserMedia($user->user_album_id, 'image'));	

		$pages = new \helpers\paginator('10','p');
		$this->data['user_videos'] = \models\albumitem::getUserMedia($user->user_album_id,'image',$pages->get_limit()); 
		$pages->set_total($total);
		$path = DIR.'user/image?';  
		$this->data['page_links'] = $pages->page_links($path,null);


		View::rendertemplate('header',$this->data);
		View::rendertemplate('mobile-menu', $this->data);
		View::render('user/user.image',$this->data);
		View::rendertemplate('footer',$this->data);
	}


	public function editmedia($parameter){
		$media_type = $parameter[0];
		$this->data['media_type'] = $media_type;
		$edit_id = $parameter[1];

		if(isset($_POST['title']) && !empty($_POST['title'])){
			$title 		 = $_POST['title'];
			$artist 		 = $_POST['artist'];
			$description = $_POST['description'];
			$youtubelink = $_POST['youtubelink'];
			$slug = \helpers\url::generateSafeSlug($title);

			if(isset($youtubelink) && $youtubelink != ''){
				$exp = explode('=', $youtubelink);
				if(count($exp) > 1 ){
					$youtubelink = $exp[1];
				}
			}

			$update_array = array(
				'album_item_artist'=>$artist,
				'album_item_title'=>$title,
				'album_item_description'=>$description,
				'album_item_youtubelink'=>$youtubelink,
				'album_item_modified'=>time(),
				'album_item_alias'=>$slug);

			$update_array = \helpers\gump::xss_clean($update_array);
			$update_array = \helpers\gump::sanitize($update_array);

			$update_id = $this->albumitem_model->updateId($update_array, $edit_id);

			if($update_id > 0){
				$message = 'ok';
			} else {
				$message = 'no';
			}


					if($media_type == 'video' && isset($youtubelink) && $youtubelink != ''){
						$youtube_url = "https://i.ytimg.com/vi/".$youtubelink."/maxresdefault.jpg";
						
						if(!file_exists($youtube_url))
							$youtube_url = "https://i.ytimg.com/vi/".$youtubelink."/hqdefault.jpg";
						

						//resize youtube image into uploads folder
						\helpers\upload::setName(time());
						\helpers\upload::resizeUrl($youtube_url,UPLOAD_PATH, '480px');
						
						$image_name = \helpers\upload::getFileName('images');
						$update_data = array('album_item_file' => $image_name);

						$this->albumitem_model->updateId($update_data, $edit_id);
						$message = 'ok';

					}



					//UPLOAD ATTACHMENT
					if($_FILES["image"]["tmp_name"] != '')
						{
							//upload image into uploads folder
							\helpers\upload::setName(uniqid());
							\helpers\upload::resizeUpload($_FILES["image"],UPLOAD_PATH, '480px');

							$image_name = \helpers\upload::getFileName('images');
							$update_data = array('album_item_file' => $image_name);
							$where_array = array('album_item_id'   => $edit_id);

							$this->albumitem_model->update($update_data, $where_array);
							$message = 'ok';
						}
					
		}


		$this->data['media'] = $this->albumitem_model->find($edit_id);

		$this->data['title'] = 'Edit '.$this->data['media']->album_item_title;

		if($message == 'ok'){
				\helpers\session::set('success','record edited');
				$url = 'user/'.$media_type;
				\helpers\url::redirect($url);
			} else if($message == 'no'){
				$this->data['error'] = 'Operation Fails!';
			}

		View::rendertemplate('header',$this->data);
		View::rendertemplate('mobile-menu', $this->data);
		View::render('user/user.media',$this->data);
		View::rendertemplate('footer',$this->data);
	}


	public function editprofile(){
		$this->data['title'] = 'Edit Profile';
		$userdance_model = new \models\userdance;
		$user_model = new \models\user;

		$this->data['user'] = \helpers\session::get('user');
		$this->data['user'] = $user_model->find(\helpers\session::get('user')->user_id);


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
			$user_slug = \helpers\url::generateSafeSlug($user_firstname.$this->data['user']->user_id.$user_lastname);

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

				$update_array = \helpers\gump::xss_clean($update_array);
				$update_array = \helpers\gump::sanitize($update_array);

				$update_id = $user_model->updateId($update_array,$this->data['user']->user_id);

				

						//UPLOAD ATTACHMENT
						if($_FILES["image"]["tmp_name"] != '')
							{
								//upload image into uploads folder
								\helpers\upload::setName($slug.uniqid());
								\helpers\upload::resizeUpload($_FILES["image"],UPLOAD_PATH, '480px');
								
								$image_name = \helpers\upload::getFileName('images');
								$update_data = array('user_image' => $image_name);

								$update_img = $this->user_model->updateId($update_data, $this->data['user']->user_id);
								
								if($update_img > 0){
									\helpers\session::set('success','Profile Updated!');
									\helpers\url::redirect('user');
								} else {
									$this->data['error'] = 'Operation Fails!';
								}

							}

				if($update_id > 0){
					\helpers\session::set('success','Profile Updated!');
					\helpers\url::redirect('user');
				} else {
					$this->data['error'] = 'Operation Fails!';
				}

				if(isset($dance_category_count) && $dance_category_count > 0){
					\helpers\session::set('success','Dance Category Updated!');
					\helpers\url::redirect('user');
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
		View::render('user/user.editprofile',$this->data);
		View::rendertemplate('footer',$this->data);	
	}


	public function password(){
		$this->data['title'] = 'Change Password';
		$user_model = new \models\user;
		$user_id = \helpers\session::get('user')->user_id;

		$user_details = $user_model->get(array('user_id'=>$user_id,
													'user_password'=>md5($_POST['old_password'])
													)
												);


		if(isset($_POST['password1']) && !empty($_POST['password1'])){

				if(count($user_details) > 0){

						if($_POST['password1'] == $_POST['password2']){
								//update user db
								$update_array = array('user_password'=>md5($_POST['password1']));
								$update_array = \helpers\gump::xss_clean($update_array);
								$update_array = \helpers\gump::sanitize($update_array);

								$update_id = $user_model->updateId($update_array,$user_id);
									
								if($update_id > 0){
									$this->data['success'] = ('Password Changed');
								} else 
									$this->data['error'] = 'Operation Fails!';
								

						} else {
							$this->data['error'] = 'Incorrect match, password change fails!';
						}

				} else {
					$this->data['error'] = 'Incorrect match, password change fails!';
				}
			}


		View::rendertemplate('header',$this->data);
		View::render('user/user.password',$this->data);
		View::rendertemplate('footer',$this->data);	
	}

	public function deleteitem($parameter){
		$media_type = $parameter[0];
		$item_id = $parameter[1];

		$model = new \models\albumitem;
		$delete = $model->deleteId($item_id);

		if($delete > 0)
			\helpers\session::set('success','record deleted!');
		else
			\helpers\session::set('error','unable to delete record!');

			// hea
			\helpers\url::redirect('user/'.$media_type);
			// header('Location: '. $_SERVER['HTTP_REFERER']);
        exit;
	}


	public function profile(){

	}


	public function addmedia($parameter){
		$media_type = $parameter[0];

		$this->data['media_type'] = $media_type;

		$this->data['album_categories'] = $this->category_model->get(array('category_slug'=>'album'));
		
		$category = $this->category_model->getColRow('category_title',$media_type);

		$this->data['title'] = 'Add '.ucfirst($media_type);

		if(isset($_POST['title']) && !empty($_POST['title'])){
			$title  	 = $_POST['title'];
			$artist 	 = $_POST['artist'];
			$description = $_POST['description'];
			$youtubelink = $_POST['youtubelink'];
			$category_id = $_POST['category'];
			// $status_id = $status->status_id;
			$slug = \helpers\url::generateSafeSlug($title);

			if(isset($youtubelink) && $youtubelink != ''){
				$exp = explode('=', $youtubelink);
				if(count($exp) > 1 ){
					$youtubelink = $exp[1];
				}
			}

			$insert_array = array(
				'album_item_album_id'=>\helpers\session::get('user')->user_album_id,
				'album_item_category_id'=>$category->category_id,
				'album_item_user_id'=>\helpers\session::get('user')->user_id,
				'album_item_title'=>$title,
				'album_item_artist'=>$artist,
				'album_item_description'=>$description,
				'album_item_youtubelink'=>$youtubelink,
				'album_item_created'=>time(),
				'album_item_alias'=>$slug);

			$insert_array = \helpers\gump::xss_clean($insert_array);

			$insert_array = \helpers\gump::sanitize($insert_array);

			$insert_id = $this->albumitem_model->create($insert_array);

			if($insert_id > 0){
				$message = 'ok';
			} else {
				$message = 'no';
			}


					//check if item is a video
					// $category_type = $this->category_model->find($_POST['category']);

					if($media_type == 'video' && isset($youtubelink) && $youtubelink != ''){
						$youtube_url = "https://i.ytimg.com/vi/".$youtubelink."/maxresdefault.jpg";
						
						if(!file_exists($youtube_url))
							$youtube_url = "https://i.ytimg.com/vi/".$youtubelink."/hqdefault.jpg";
						

						//resize youtube image into uploads folder
						\helpers\upload::setName(time());
						\helpers\upload::resizeUrl($youtube_url,UPLOAD_PATH, '480px');
						
						$image_name = \helpers\upload::getFileName('images');
						$update_data = array('album_item_file' => $image_name);
						$where_array = array('album_item_id' => $insert_id);

						$this->albumitem_model->update($update_data, $where_array);
					}

					

					//UPLOAD ATTACHMENT
					if($_FILES["image"]["tmp_name"] != '')
						{
							//upload image into uploads folder
							\helpers\upload::setName(uniqid());
							\helpers\upload::resizeUpload($_FILES["image"],UPLOAD_PATH, '480px');

							
							$image_name = \helpers\upload::getFileName('images');
							$update_data = array('album_item_file' => $image_name);
							$where_array = array('album_item_id'=>$insert_id);

							$this->albumitem_model->update($update_data, $where_array);
						}

		}

		if($message == 'ok'){
				\helpers\session::set('success','record edited');
				$url = 'user/'.$media_type;
				\helpers\url::redirect($url);
			} else if($message == 'no'){
				$this->data['error'] = 'Operation Fails!';
			}

		View::rendertemplate('header',$this->data);
		View::rendertemplate('mobile-menu', $this->data);
		View::render('user/user.media',$this->data);
		View::rendertemplate('footer',$this->data);
	}



	
}
