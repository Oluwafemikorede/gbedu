<?php 
namespace Controllers;

use Core\View;
use Core\Controller;


use Helpers\Paginator;
use Helpers\Session;
use Helpers\Url;
use Helpers\Upload;
use Helpers\Gump;
use Helpers\Audio;
use Helpers\Document;
use Helpers\PhpMailer\Mail;

// use Models\Album;
use Models\Media;
use Models\Category;
use Models\Status;
use Models\User;


/*
 * Welcome controller
 *
 * @author David Carr - dave@daveismyname.com - http://www.daveismyname.com
 * @version 2.1
 * @date June 27, 2014
 */
class Album extends Controller{

	/**
	 * call the parent construct
	 */
	public $album_model;
	public $category_model;
	public $status_model;
	public $albumitem_model;
	public function __construct(){
		parent::__construct();

		$this->albumModel = new \Models\Album;
		$this->status_model = new Status;
		$this->mediaModel = new Media;
		$this->categoryModel = new Category;
	}

	/**
	 * define page title and load template files
	 */
	public function index(){

		
		$this->data['title'] = 'Albums';
		$this->data['category'] = Category::row('category_slug','playlist');



		if(isset($_POST) && !empty($_POST)){

			//generate slug
			$slug = Url::generateSafeSlug($_POST['title']);

			$albumArray = array('album_name'=>$_POST['title'],
								'album_user_id'=>Session::get('user_id'),
								'album_description'=>$_POST['description'],
								'album_created'=>time());

			$albumArray = Gump::xss_clean($albumArray);
			$albumArray = Gump::sanitize($albumArray);

			$album_id = $this->albumModel->create($albumArray);

			if($album_id > 0){

			$checkSlug = $this->albumModel->getColRow('album_slug',$slug);

			if(!is_bool($checkSlug)){
				$updateSlug = $this->albumModel->updateId(array('album_slug'=>$slug.$album_id),$album_id);
			} 

					//UPLOAD ALBUM COVER
					if($_FILES["image"]["tmp_name"] != '')
						{
							//upload file into uploads folder
							Upload::setName(time());
							Upload::resizeUpload($_FILES["image"],UPLOAD_PATH, '480px');
							
							$update_data = array('album_image' => Upload::getFileName('images'));

							$this->albumModel->updateId($update_data, $album_id);
						}


				Session::set('success','Album Created');
			} else {
				Session::set('error','Operation Fails');
			}
		}

		
		$this->data['albums'] = $this->albumModel->allalbum();

		View::rendertemplate('header', $this->data);
		View::rendertemplate('sidebar', $this->data);
		View::render('album/album.index', $this->data);
		View::rendertemplate('footer', $this->data);
	} 



	public function editalbum($parameter){
		$edit_id = $parameter[0];

		$this->data['title'] = 'Edit Album';


		if(isset($_POST) && !empty($_POST)){
			$title = $_POST['title'];
			$description = $_POST['description'];

			$albumArray = array('album_name'=>$title,'album_description'=>$description);

			// $where_array = array('album_id'=>$edit_id);

			$albumArray = Gump::xss_clean($albumArray);
			$albumArray = Gump::sanitize($albumArray);

			$update = $this->albumModel->updateId($update_array, $edit_id);

			if($update > 0){
				// $this->data['success'] = 'Album edited';
				Session::set('success','Album edited');
				Url::redirect('album');
			} else {
				$this->data['error'] = 'Operation Fails';
			}
		}

		
		$this->data['album_data'] = $this->albumModel->find($edit_id);

		View::rendertemplate('header', $this->data);
		View::rendertemplate('sidebar', $this->data);
		View::render('album/editalbum', $this->data);
		View::rendertemplate('footer', $this->data);
	} 


	public function media($param){
		$album_id = $param[0];

		$this->data['album_id'] = $album_id;
		if(isset($param[1]) && !empty($param[1])){
			$user_id = $param[1];
		}

		$this->data['artist'] = User::artist();

		$album_detail = $this->albumModel->find($album_id);

		$this->data['title'] = ucfirst($album_detail->album_name).' Album';

		
		$albumitems = $this->mediaModel->getAlbumItems($album_id);
		$this->data['category'] = $this->categoryModel->get(array('category_slug'=>'album'));
		$this->data['status'] = $this->status_model->get(array('status_slug'=>'album'));


		if(isset($_POST) && !empty($_POST)){
			$title = $_POST['title'];
			$description = $_POST['description'];
			$youtubelink = $_POST['youtubelink'];
			$category_id = $_POST['category'];
			$status_id = $_POST['status_id'];
			$slug = Url::generateSafeSlug($title);

			$mediaArray = array(
				'media_album_id'=>$album_id,
				'media_category_id'=>$category_id,
				'media_status_id'=>$status_id,
				'media_title'=>$title,
				'media_description'=>$description,
				'media_youtubelink'=>$youtubelink,
				'media_created'=>time(),
				'media_slug'=>$slug);

			$mediaArray = Gump::xss_clean($mediaArray);
			$mediaArray = Gump::sanitize($mediaArray);

			$media_id = $this->mediaModel->create($mediaArray);

			if($media_id > 0){
				$message = 'ok';
			} else {
				$message = 'no';
			}

		

					//check if item is a video
					$category_type = $this->categoryModel->find($_POST['category']);

					if($category_type->category_title == 'video' && isset($youtubelink) && $youtubelink != ''){
						//item is a video
						$youtube_url = "https://i.ytimg.com/vi/".$youtubelink."/maxresdefault.jpg";
						if(!file_exists($youtube_url))
						{
							$youtube_url = "https://i.ytimg.com/vi/".$youtubelink."/hqdefault.jpg";
						}

						//resize youtube image into uploads folder
						Upload::setName(time());
						Upload::resizeUrl($youtube_url,UPLOAD_PATH, '480px');
						
						$image_name = Upload::getFileName('images');
						$update_data = array('media_file' => $image_name);

						$this->mediaModel->updateId($update_data, $media_id);
					}


					if($_FILES["image"]["tmp_name"] != '' && $category_type->category_title == 'audio'){
						//resize youtube image into uploads folder
						Upload::setName(time());
						Upload::upload_file($_FILES["image"],UPLOAD_PATH);

						$filepath 	   = UPLOAD_PATH.Upload::getName();
						$outputMp3 = UPLOAD_PATH.'encoded_'.Upload::getName();

						//check bitrate
						$bitRate  = Audio::bitRateSampleRate($filepath,'bitrate');

						if($bitRate > 128){
							$convertMp3 = Audio::convertMp3($filepath, 128, $outputMp3);
						}

						if(is_file($outputMp3)){
							$updateArray = array('media_file' => 'images/encoded_'.Upload::getName() );
							unlink($filepath);
						} else {
							$updateArray = array('media_file' => Upload::getFileName('images') );
						}
						
						$saveMp3 = $this->mediaModel->updateId($updateArray, $media_id);

					}

					//UPLOAD ATTACHMENT
					if($_FILES["image"]["tmp_name"] != '' && $category_type->category_title == 'image')
						{
							//upload file into uploads folder
							Upload::setName(uniqid());
							Upload::resizeUpload($_FILES["image"],UPLOAD_PATH, '480px');
							
							$image_name = Upload::getFileName('images');
							$update_data = array('media_file' => $image_name);

							$this->mediaModel->update($update_data, $media_id);
						}

		}

		if($message == 'ok'){
			$this->data['success'] = 'Record Added!';
		} else if($message == 'no'){
			$this->data['error'] = 'Operation Fails!';
		}

		$total = count($this->mediaModel->albumItems($album_id));	

		$pages = new Paginator('6','p');
		$this->data['albumitems'] = $this->mediaModel->albumItems( $album_id, $pages->getLimit() );
		$pages->setTotal($total);
		$path = DIR.'album/media/'.$album_id.'?';  
		$this->data['page_links'] = $pages->pageLinks($path,null);

		View::rendertemplate('header', $this->data);
		View::rendertemplate('sidebar', $this->data);
		View::render('album/album.add_item', $this->data);
		View::rendertemplate('footer', $this->data);
	}


	public function user($param){
		$album_id = $param[0];
		$user_id = $param[1];

		$this->data['album_id'] = $album_id;
		$this->data['user_id'] = $user_id;
		

		$album_detail = $this->albumModel->find($album_id);

		$this->data['title'] = ucfirst($album_detail->album_name).' Album';

		
		$albumitems = $this->mediaModel->getAlbumItems($album_id);
		$this->data['album_categories'] = $this->categoryModel->get(array('category_slug'=>'album'));
		$this->data['status'] = $this->status_model->get(array('status_slug'=>'album'));


		if(isset($_POST) && !empty($_POST)){
			$title = $_POST['title'];
			$description = $_POST['description'];
			$youtubelink = $_POST['youtubelink'];
			$category_id = $_POST['category'];
			$status_id = $_POST['status_id'];
			$slug = Url::generateSafeSlug($title);



			$insert_array = array(
				'media_album_id'=>$album_id,
				'media_category_id'=>$category_id,
				'media_status_id'=>$status_id,
				'media_user_id'=>$user_id,
				'media_title'=>$title,
				'media_description'=>$description,
				'media_youtubelink'=>$youtubelink,
				'media_created'=>time(),
				'media_alias'=>$slug);

			$insert_array = Gump::xss_clean($insert_array);

			$insert_array = Gump::sanitize($insert_array);

			$insert_id = $this->mediaModel->create($insert_array);

			if($insert_id > 0){
				$message = 'ok';
			} else {
				$message = 'no';
			}

			//update where_array
			$where_array = array('media_id' => $insert_id);

					//check if item is a video
					$category_type = $this->categoryModel->find($_POST['category']);

					if($category_type->category_title == 'video' && isset($youtubelink) && $youtubelink != ''){
						//item is a video
						$youtube_url = "https://i.ytimg.com/vi/".$youtubelink."/maxresdefault.jpg";
						if(!file_exists($youtube_url))
						{
							$youtube_url = "https://i.ytimg.com/vi/".$youtubelink."/hqdefault.jpg";
						}

						//resize youtube image into uploads folder
						Upload::setName(time());
						Upload::resizeUrl($youtube_url,UPLOAD_PATH, '480px');
						
						$image_name = Upload::getFileName('images');
						$update_data = array('media_file' => $image_name);

						$this->mediaModel->update($update_data, $where_array);
					}

					//UPLOAD ATTACHMENT
					if($_FILES["image"]["tmp_name"] != '')
						{
							//upload image into uploads folder
							Upload::setName(uniqid());
							// Upload::upload_file($_FILES["image"],UPLOAD_PATH);
							Upload::resizeUpload($_FILES["image"],UPLOAD_PATH, '480px');

							
							$image_name = Upload::getFileName('images');
							$update_data = array('media_file' => $image_name);

							$this->mediaModel->update($update_data, $where_array);
						}
		}

		if(isset($_GET['a']) && $_GET['a'] == 'delete'){
			if($delete = $this->mediaModel->delete(array('media_id'=>$_GET['qid'])))
				$message = 'ok';
			else
				$message = 'no';
		}


		if(isset($_GET['status'])){
			switch ($_GET['status']) {
				case 'deactivate':
					$deactivate = $this->status_model->get_row(array('status_title'=>'inactive'));
					$update_user = $this->mediaModel->update(
						array('media_status_id'=>$deactivate->status_id), 
						array('media_id'=>$_GET['id']));
					break;

				case 'activate':
					$activate = $this->status_model->get_row(array('status_title'=>'active'));
					$update_user = $this->mediaModel->update(
						array('media_status_id'=>$activate->status_id), 
						array('media_id'=>$_GET['id']));
					break;
			}
			if(isset($update_user)){
				$this->data['success'] = 'status changed!';
			} else {
				$this->data['error'] = 'operation fails';
			}
		}

		if($message == 'ok'){
			$this->data['success'] = 'Record Added!';
		} else if($message == 'no'){
			$this->data['error'] = 'Operation Fails!';
		}

		$this->data['albumitems'] = $this->mediaModel->getAlbumItems($album_id, $user_id);

		View::rendertemplate('header', $this->data);
		View::rendertemplate('sidebar', $this->data);
		View::render('album/album.user.add_item', $this->data);
		View::rendertemplate('footer', $this->data);
	}


	public function edit($param){
		$media_id = $param[0];

		//get album detail
		$albumitem_detail = $this->mediaModel->find($media_id);


		$this->data['title'] = 'Edit Item';

		$this->data['album_categories'] = $this->categoryModel->get(array('category_slug'=>'album'));
		$this->data['status'] = $this->status_model->get(array('status_slug'=>'album'));

		
		if(isset($_POST) && !empty($_POST)){
			$slug = Url::generateSafeSlug($_POST['title']);

			$mediaArray = array(
				'media_category_id'=>$_POST['category'],
				'media_user_id'=>Session::get('user_id'),
				'media_title'=>$_POST['title'],
				'media_description'=>$_POST['description'],
				'media_youtubelink'=>$_POST['youtubelink'],
				'media_slug'=>$slug,
				'media_modified'=>time());

			$update = $this->mediaModel->updateId($mediaArray, $media_id);

			if($update > 0){
				$message = 'ok';
			} else {
				$message = 'no';
			} 		

					//check if item is a video
					$category_type = $this->categoryModel->find($_POST['category']);

					if($category_type->category_title == 'video' && isset($_POST['youtubelink']) && $_POST['youtubelink'] != ''){
						//item is a video
						$youtube_url = "https://i.ytimg.com/vi/".$_POST['youtubelink']."/maxresdefault.jpg";
						
						if(!file_exists($youtube_url))
						{
							$youtube_url = "https://i.ytimg.com/vi/".$_POST['youtubelink']."/hqdefault.jpg";
						}
						//resize youtube image into uploads folder
						Upload::setName(time());
						Upload::resizeUrl($youtube_url,UPLOAD_PATH, '480px');
						
						$update_data = array('media_file' => Upload::getFileName('images'));

						$this->mediaModel->updateId($update_data, $media_id);
					}


					if($_FILES["image"]["tmp_name"] != '' && $category_type->category_title == 'audio'){
						//resize youtube image into uploads folder
						Upload::setName(time());
						Upload::upload_file($_FILES["image"],UPLOAD_PATH);

						$filepath 	   = UPLOAD_PATH.Upload::getName();
						$outputMp3 = UPLOAD_PATH.'encoded_'.Upload::getName();

						//check bitrate
						$bitRate  = Audio::bitRateSampleRate($filepath,'bitrate');

						if($bitRate > 128){
							$convertMp3 = Audio::convertMp3($filepath, 128, $outputMp3);
						}

						if(is_file($outputMp3)){
							$updateArray = array('media_file' => 'images/encoded_'.Upload::getName() );
							unlink($filepath);
						} else {
							$updateArray = array('media_file' => Upload::getFileName('images') );
						}
						
						$saveMp3 = $this->mediaModel->updateId($updateArray, $media_id);

					}


				//UPLOAD ATTACHMENT
				if($_FILES["image"]["tmp_name"] != '' && $category_type->category_title == 'image')
					{
						//upload image into uploads folder
						Upload::setName(time());
						Upload::resizeUpload($_FILES["image"],UPLOAD_PATH, '480px');

						$update_data = array('media_file' => Upload::getFileName('images'));

						$update_img = $this->mediaModel->updateId($update_data, $media_id);

						if($update_img > 0){
							Session::set('success','record edited');
							Url::redirect('album/media/'.$albumitem_detail->media_album_id);
						} else if($message == 'no'){
							$this->data['error'] = 'Operation Fails!';
						}
					}

		}


			if($message == 'ok'){
				Session::set('success','record edited');
				Url::redirect('album/media/'.$albumitem_detail->media_album_id);
			} else if($message == 'no'){
				$this->data['error'] = 'Operation Fails!';
			}

		$this->data['media'] = Media::row('media_id',$media_id);
		
		
		View::rendertemplate('header', $this->data);
		View::rendertemplate('sidebar', $this->data);
		View::render('album/album.edit_item', $this->data);
		View::rendertemplate('footer', $this->data);
	}


	public function video($param){
		$album_id = $param[0];

		$this->data['album_id'] = $album_id;
		if(isset($param[1]) && !empty($param[1])){
			$user_id = $param[1];
		}

		$album_detail = $this->albumModel->find($album_id);

		$this->data['title'] ='Video Album';

		
		$total = count($this->mediaModel->media('video'));	

		$pages = new Paginator('6','p');
		$this->data['albumitems'] = $this->mediaModel->media('video', $pages->getLimit());
		$pages->setTotal($total);
		$path = DIR.'album/video?';  
		$this->data['page_links'] = $pages->pageLinks($path,null);

		View::rendertemplate('header', $this->data);
		View::rendertemplate('sidebar', $this->data);
		View::render('album/album.video', $this->data);
		View::rendertemplate('footer', $this->data);
	}

	public function image($param){
		$album_id = $param[0];

		$this->data['album_id'] = $album_id;
		if(isset($param[1]) && !empty($param[1])){
			$user_id = $param[1];
		}

		$album_detail = $this->albumModel->find($album_id);

		$this->data['title'] = 'Picture Album';

		$total = count($this->mediaModel->media('image'));	

		$pages = new Paginator('6','p');
		$this->data['albumitems'] = $this->mediaModel->media('image', $pages->getLimit());
		$pages->setTotal($total);
		$path = DIR.'album/image?';  
		$this->data['page_links'] = $pages->pageLinks($path,null);

		View::rendertemplate('header', $this->data);
		View::rendertemplate('sidebar', $this->data);
		View::render('album/album.video', $this->data);
		View::rendertemplate('footer', $this->data);
	}


	public function delete($parameter){
		$type = $parameter[0];
		$id = $parameter[1];

		if($type == 'album'){
			$model = new \Models\Album;
		} else {
			$model = new Media;
			$item = $model->find($id);
		}

		$delete = $model->deleteId($id);
		

		if($delete > 0){
			Session::set('success','record deleted!');

			$file = DEL_PATH.$item->media_file;

			if(is_file($file)){
				unlink($file);
			}

		} else {
			Session::set('error','operation fails!');

		}

			Url::previous();
	}


	public function status($parameter){
		$action = $parameter[0];
		$id = $parameter[1];

		$model = new \models\albumitem;
		$status_model = new \models\status;

		if($action == 'deactivate'){
			$status = $status_model->getColRow('status_title','inactive');
			$update = $model->updateId(	array('media_status_id'=>$status->status_id),$id );
		} else if($action == 'activate'){
			$status = $status_model->getColRow('status_title','active');
			$update = $model->updateId(array('media_status_id'=>$status->status_id), $id);
		}

		if($update > 0)
			Session::set('success','status edited!');
		else
			Session::set('error','operation fails!');
		

		Url::previous();
	}


	public function feature($parameter){
		$action = $parameter[0];
		$id = $parameter[1];

		$model = new \models\albumitem;
		$status_model = new \models\status;

		// if($action == 'unfeature'){
		// 	$update = $model->updateId(	array('media_featured'=>0),$id );
		// } else if($action == 'feature'){
		// 	$update = $model->updateId(array('media_featured'=>1), $id);
		// }

		switch ($action) {
			case 'unfeature':
			$update = $model->updateId(	array('media_featured'=>0),$id );
				break;

			case 'feature':
			$update = $model->updateId(	array('media_featured'=>1),$id );
				break;

			case 'singlefeature':
			$update = $model->updateId(	array('media_featured'=>2),$id );
				break;
			
			default:
				# code...
				break;
		}

		if($update > 0)
			Session::set('success','video featured!');
		else
			Session::set('error','operation fails!');
		

		Url::previous();
	}		

}
