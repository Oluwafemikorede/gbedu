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
use Helpers\Auth;

use Models\Album;
use Models\Media;
use Models\Category;
use Models\Status;
use Models\User;
use Models\Playlist;


/*
 * Welcome controller
 *
 * @author David Carr - dave@daveismyname.com - http://www.daveismyname.com
 * @version 2.1
 * @date June 27, 2014
 */
class Song extends Controller{

	/**
	 * call the parent construct
	 */
	public $album_model;
	public $category_model;
	public $status_model;
	public $albumitem_model;
	public function __construct(){
		parent::__construct();
        Auth::block();

		$this->albumModel = new Album;
		$this->status_model = new Status;
		$this->mediaModel = new Media;
		$this->categoryModel = new Category;
	}

	/**
	 * load all songs
	 */
	public function index(){
		$this->data['title'] = 'All Songs';

		$total = count(\Models\Song::items());	

		$pages = new Paginator('10','p');
		$this->data['songs'] = \Models\Song::items($pages->getLimit() );
		$pages->setTotal($total);
		$path = DIR.'song?';  
		$this->data['page_links'] = $pages->pageLinks($path,null);

		View::rendertemplate('header', $this->data);
		View::rendertemplate('sidebar', $this->data);
		View::render('song/song.allitems', $this->data);
		View::rendertemplate('footer', $this->data);
	} 


	public function add(){
		$songModel = new \Models\Song;
		$tagModel = new \Models\Songtag;

		$this->data['title'] = ucfirst($album_detail->album_name).' Album';

		$this->data['artist'] = User::artist();
		$this->data['genre'] = $this->categoryModel->get(array('category_slug' => 'genre'));
		$this->data['tags']   = $this->categoryModel->get(array('category_slug' => 'tag'));
		$this->data['status'] = $this->status_model->get(array('status_slug'=>'album'));


		if(isset($_POST) && !empty($_POST)){
			$songArray = array(
				'song_album_id'		=>	Album::id('album_slug','gbedu-album'),
				'song_user_id'		=>	Session::get('user_id'),
				'song_artist_id'	=> 	$_POST['artist_id'],
				'song_genre_id'		=> 	$_POST['genre_id'],
				'song_status_id'	=> 	$_POST['status_id'],
				'song_title'		=>	$_POST['title'],
				'song_description'	=>	$_POST['description'],
				'song_created'		=>	time(),
				'song_slug'			=>	Url::generateSafeSlug($_POST['title']));

			$songArray = Gump::xss_clean($songArray);
			$songArray = Gump::sanitize($songArray);

			$song_id = $songModel->create($songArray);

			//attach tags
			if(count($_POST['tags']) > 0){
				foreach($_POST['tags'] as $id){
					$tag_id = $tagModel->create(array('songtag_category_id'=>$id,'songtag_song_id'=>$song_id));
				}
			}

			if($song_id > 0){
				$message = 'ok';
			} else {
				$message = 'no';
			}



					if($_FILES["mp3"]["tmp_name"] != ''){
						//resize youtube image into uploads folder
						Upload::setName(time());
						Upload::upload_file($_FILES["mp3"],UPLOAD_PATH);

						$filepath 	   = UPLOAD_PATH.Upload::getName();
						$outputMp3 = UPLOAD_PATH.'encoded_'.Upload::getName();

						//check bitrate
						$bitRate  = Audio::bitRateSampleRate($filepath,'bitrate');

						$duration = Audio::duration($filepath);

						if($bitRate > 128){
							$convertMp3 = Audio::convertMp3($filepath, 128, $outputMp3);
						}

						if(is_file($outputMp3)){
							$updateArray = array(
								'song_file' => 'images/encoded_'.Upload::getName(),
								'song_duration' => $duration );
							unlink($filepath);
						} else {
							$updateArray = array(
								'song_file' => Upload::getFileName('images'),
								'song_duration' => $duration );
						}
						
						$saveMp3 = $songModel->updateId($updateArray, $song_id);

					}


					//UPLOAD SONG COVER
					if($_FILES["image"]["tmp_name"] != '')
						{
							//upload file into uploads folder
							Upload::setName(time());
							Upload::resizeUpload($_FILES["image"],UPLOAD_PATH, '450px');
							
							$update_data = array('song_image' => Upload::getFileName('images'));

							$songModel->updateId($update_data, $song_id);
						}

		}

		if($message == 'ok'){
			Session::set('success', 'Record Added!');
			Url::redirect('song');
		} else if($message == 'no'){
			Session::set('error', 'Operation Fails!');
		}

		
		View::rendertemplate('header', $this->data);
		View::rendertemplate('sidebar', $this->data);
		View::render('song/song.add', $this->data);
		View::rendertemplate('footer', $this->data);
	}


	/**
	 * define page title and load template files
	 */
	public function album(){
		$this->data['title'] = 'Albums';

		if(isset($_POST) && !empty($_POST)){
			$slug = Url::generateSafeSlug($_POST['title']); //generate slug

			$albumArray = array('album_name'=>$_POST['title'],
								'album_user_id'=>Session::get('user_id'),
								'album_category_id'=>Category::id('category_title','album'),
								'album_description'=>$_POST['description'],
								'album_slug'=>$slug.'pl',
								'album_created'=>time());

			$albumArray = Gump::xss_clean($albumArray);
			$albumArray = Gump::sanitize($albumArray);

			$album_id = $this->albumModel->create($albumArray);

			if($album_id > 0){

			$checkSlug = $this->albumModel->getColRow('album_slug',$slug);

			if(!is_bool($checkSlug)){
				$updateSlug = $this->albumModel->updateId(array('album_slug'=>$slug.'pl'.$album_id),$album_id);
			} 

					//UPLOAD ALBUM COVER
					if($_FILES["image"]["tmp_name"] != '')
						{
							//upload file into uploads folder
							Upload::setName(time());
							Upload::resizeUpload($_FILES["image"],UPLOAD_PATH, 300);
							
							$update_data = array('album_image' => Upload::getFileName('images'));
							$this->albumModel->updateId($update_data, $album_id);
						}

				Session::set('success','Album Created');
			} else {
				Session::set('error','Operation Fails');
			}
		}

		
		$this->data['albums'] = $this->albumModel->allalbum();

		$total = count(Album::type('album'));	

		$pages = new Paginator('5','p');
		$this->data['albums'] = Album::type('album', $pages->getLimit());
		$pages->setTotal($total);
		$path = DIR.'song/album?';  
		$this->data['pageLinks'] = $pages->pageLinks($path,null);

		View::rendertemplate('header', $this->data);
		View::rendertemplate('sidebar', $this->data);
		View::render('song/song.album', $this->data);
		View::rendertemplate('footer', $this->data);
	} 


	public function playlist(){
		$this->data['title'] = 'Song Playlists';

		if(isset($_POST) && !empty($_POST)){
			//generate slug
			$slug = Url::generateSafeSlug($_POST['title']);

			$albumArray = array('album_name'=>$_POST['title'],
								'album_user_id'=>Session::get('user_id'),
								'album_category_id'=>Category::id('category_title','playlist'),
								'album_description'=>$_POST['description'],
								'album_slug'=>$slug.'pl',
								'album_created'=>time());

			$albumArray = Gump::xss_clean($albumArray);
			$albumArray = Gump::sanitize($albumArray);

			$album_id = $this->albumModel->create($albumArray);

			if($album_id > 0){

			$checkSlug = $this->albumModel->getColRow('album_slug',$slug);

					if(!is_bool($checkSlug)){
						$updateSlug = $this->albumModel->updateId(array('album_slug'=>$slug.'pl'.$album_id),$album_id);
					} 

					//UPLOAD ALBUM COVER
					if($_FILES["image"]["tmp_name"] != '')
						{
							//upload file into uploads folder
							Upload::setName(time());
							Upload::resizeUpload($_FILES["image"],UPLOAD_PATH, 300);
							
							$update_data = array('album_image' => Upload::getFileName('images'));

							$this->albumModel->updateId($update_data, $album_id);
						}

				Session::set('success','Playlist Created');
			} else {
				Session::set('error','Operation Fails');
			}
		}

		
		$this->data['albums'] = $this->albumModel->allalbum();

		$total = count(Album::type('playlist'));	

		$pages = new Paginator('5','p');
		$this->data['albums'] = Album::type('playlist', $pages->getLimit());
		$pages->setTotal($total);
		$path = DIR.'song/playlist?';  
		$this->data['pageLinks'] = $pages->pageLinks($path,null);

		View::rendertemplate('header', $this->data);
		View::rendertemplate('sidebar', $this->data);
		View::render('song/song.playlist', $this->data);
		View::rendertemplate('footer', $this->data);
	}

	/**
	* add songs to playlist
	*
	**/
	public function tagplaylist($param){
		$album_id = $param[0];
		$songModel = new \Models\Song;
		$tagModel = new \Models\Songtag;
		$playlistModel = new Playlist;


		$album_detail = $this->albumModel->find($album_id);

		$this->data['title'] = ucfirst($album_detail->album_name);


		if(isset($_POST) && !empty($_POST)){
			//attach tags
			if(count($_POST['tag_songs']) > 0){
				foreach($_POST['tag_songs'] as $item){
					$playlistArray = array(
										'playlist_album_id'		=>	$album_id,
										'playlist_song_id'		=> 	$item,
										'playlist_created'		=>	time());

					$playlistArray = Gump::xss_clean($playlistArray);
					$playlistArray = Gump::sanitize($playlistArray);

					$playlist_id = $playlistModel->create($playlistArray);
				}
			}

			if($playlist_id > 0){
				$message = 'ok';
				Session::set('success','Songs has been added to playlist');
			} else {
				Session::set('error','tagging fails');
			}

		}

		$total = count(Playlist::items($album_id));	

		$pages = new Paginator('10','p');
		$this->data['songs'] = Playlist::items($album_id, $pages->getLimit() );
		$pages->setTotal($total);
		$path = DIR.'song/tagplaylist/'.$album_id.'?';  
		$this->data['page_links'] = $pages->pageLinks($path,null);

		$this->data['tag_songs'] = $songModel->all();


		View::rendertemplate('header', $this->data);
		View::rendertemplate('sidebar', $this->data);
		View::render('song/song.tagplaylist', $this->data);
		View::rendertemplate('footer', $this->data);
	} 

	/**
	* remove song from playlist
	**/
	public function untag($parameter){
		$song_id = $parameter[0];
		$playlist_id = $parameter[1];

			$model = new \Models\Playlist;
			$item = $model->find($id);

		$delete = $model->delete(array('playlist_album_id'=>$playlist_id, 'playlist_song_id'=>$song_id));
		

		if($delete > 0){
			Session::set('success','record deleted!');
		} else {
			Session::set('error','operation fails!');

		}

			Url::previous();
	}


	public function editalbum($parameter){
		$edit_id = $parameter[0];

		$this->data['title'] = 'Edit Album';


		if(isset($_POST) && !empty($_POST)){
			$albumArray = array('album_name'		=>	$_POST['title'],
								'album_description'	=>	$_POST['description'],
								'album_slug'		=>	Url::generateSafeSlug($_POST['title']).'pl'.$edit_id);

			$albumArray = Gump::xss_clean($albumArray);
			$albumArray = Gump::sanitize($albumArray);

			$update = $this->albumModel->updateId($albumArray, $edit_id);

					//UPLOAD ALBUM COVER
					if($_FILES["image"]["tmp_name"] != '')
						{
							//upload file into uploads folder
							Upload::setName(time());
							Upload::resizeUpload($_FILES["image"],UPLOAD_PATH, '300px');
							
							$update_data = array('album_image' => Upload::getFileName('images'));

							$update = $this->albumModel->updateId($update_data, $edit_id);

							if($update > 0){
								Session::set('success','Album edited');
								Url::redirect('song');
							} else {
								$this->data['error'] = 'Operation Fails';
							}
						}


			if($update > 0){
				Session::set('success','Album edited');
				Url::redirect('song');
			} else {
				$this->data['error'] = 'Operation Fails';
			}
		}

		
		$this->data['album_data'] = $this->albumModel->find($edit_id);

		View::rendertemplate('header', $this->data);
		View::rendertemplate('sidebar', $this->data);
		View::render('song/editalbum', $this->data);
		View::rendertemplate('footer', $this->data);
	} 

	
	/**
	 * display album songs and add song
	 */
	public function item($param){
		$album_id = $param[0];
		$songModel = new \Models\Song;
		$tagModel = new \Models\Songtag;

		$this->data['album_id'] = $album_id;
		if(isset($param[1]) && !empty($param[1])){
			$user_id = $param[1];
		}


		$album_detail = $this->albumModel->find($album_id);

		$this->data['title'] = ucfirst($album_detail->album_name).' Album';

		$this->data['artist'] = User::artist();
		$this->data['genre'] = $this->categoryModel->get(array('category_slug' => 'genre'));
		$this->data['tags']   = $this->categoryModel->get(array('category_slug' => 'tag'));
		$this->data['status'] = $this->status_model->get(array('status_slug'=>'album'));


		if(isset($_POST) && !empty($_POST)){
			$songArray = array(
				'song_album_id'		=>	$album_id,
				'song_user_id'		=>	Session::get('user_id'),
				'song_artist_id'	=> 	$_POST['artist_id'],
				'song_genre_id'		=> 	$_POST['genre_id'],
				'song_status_id'	=> 	$_POST['status_id'],
				'song_title'		=>	$_POST['title'],
				'song_description'	=>	$_POST['description'],
				'song_created'		=>	time(),
				'song_slug'			=>	Url::generateSafeSlug($_POST['title']));

			$songArray = Gump::xss_clean($songArray);
			$songArray = Gump::sanitize($songArray);

			$song_id = $songModel->create($songArray);

			//attach tags
			// var_dump($_POST['tags']);
			if(count($_POST['tags']) > 0){
				foreach($_POST['tags'] as $id){
					$tag_id = $tagModel->create(array('songtag_category_id'=>$id,'songtag_song_id'=>$song_id));
				}
			}

			if($song_id > 0){
				$message = 'ok';
			} else {
				$message = 'no';
			}



					if($_FILES["mp3"]["tmp_name"] != ''){
						//resize youtube image into uploads folder
						Upload::setName(time());
						Upload::upload_file($_FILES["mp3"],UPLOAD_PATH);

						$filepath 	   = UPLOAD_PATH.Upload::getName();
						$outputMp3 = UPLOAD_PATH.'encoded_'.Upload::getName();

						//check bitrate
						$bitRate  = Audio::bitRateSampleRate($filepath,'bitrate');

						$duration = Audio::duration($filepath);


						if($bitRate > 128){
							$convertMp3 = Audio::convertMp3($filepath, 128, $outputMp3);
						}

						if(is_file($outputMp3)){
							$updateArray = array(
								'song_file' => 'images/encoded_'.Upload::getName(),
								'song_duration' => $duration );
							unlink($filepath);
						} else {
							$updateArray = array(
								'song_file' => Upload::getFileName('images'),
								'song_duration' => $duration );
						}
						
						$saveMp3 = $songModel->updateId($updateArray, $song_id);

					}


					//UPLOAD SONG COVER
					if($_FILES["image"]["tmp_name"] != '')
						{
							//upload file into uploads folder
							Upload::setName(time());
							Upload::resizeUpload($_FILES["image"],UPLOAD_PATH, '450px');
							
							$update_data = array('song_image' => Upload::getFileName('images'));

							$songModel->updateId($update_data, $song_id);
						}

		}

		if($message == 'ok'){
			$this->data['success'] = 'Record Added!';
		} else if($message == 'no'){
			$this->data['error'] = 'Operation Fails!';
		}

		$total = count(\Models\Song::album($album_id));	

		$pages = new Paginator('6','p');
		$this->data['songs'] = \Models\Song::album($album_id, $pages->getLimit() );
		$pages->setTotal($total);
		$path = DIR.'song/item/'.$album_id.'?';  
		$this->data['page_links'] = $pages->pageLinks($path,null);

		View::rendertemplate('header', $this->data);
		View::rendertemplate('sidebar', $this->data);
		View::render('song/song.item', $this->data);
		View::rendertemplate('footer', $this->data);
	}


	public function edit($param){
		$song_id = $param[0];

		$songModel = new \Models\Song;

		$this->data['title'] = 'Edit Song';

		$this->data['albums'] = $this->albumModel->all();
		$this->data['artist'] = User::artist();
		$this->data['genre'] = $this->categoryModel->get(array('category_slug' => 'genre'));
		$this->data['tags']   = $this->categoryModel->get(array('category_slug' => 'tag'));
		$this->data['status'] = $this->status_model->get(array('status_slug'=>'album'));

		
		if(isset($_POST) && !empty($_POST)){
			$songArray = array(
				'song_album_id'		=>	$_POST['album_id'],
				'song_user_id'		=>	Session::get('user_id'),
				'song_artist_id'	=> 	$_POST['artist_id'],
				'song_genre_id'		=> 	$_POST['genre_id'],
				'song_status_id'	=> 	$_POST['status_id'],
				'song_title'		=>	$_POST['title'],
				'song_description'	=>	$_POST['description'],
				'song_modified'		=>	time(),
				'song_slug'			=>	Url::generateSafeSlug($_POST['title']));

			$songArray = Gump::xss_clean($songArray);
			$songArray = Gump::sanitize($songArray);

			$update = $songModel->updateId($songArray, $song_id);

			if($update > 0){
				$message = 'ok';
			} else {
				$message = 'no';
			} 		

					

					if($_FILES["mp3"]["tmp_name"] != ''){
						//resize youtube image into uploads folder
						Upload::setName(time());
						Upload::upload_file($_FILES["mp3"],UPLOAD_PATH);

						$filepath = UPLOAD_PATH.Upload::getName();
						$outputMp3 = UPLOAD_PATH.'encoded_'.Upload::getName();

						//check bitrate
						$bitRate  = Audio::bitRateSampleRate($filepath,'bitrate');

						$duration = Audio::duration($filepath);


						if($bitRate > 128){
							$convertMp3 = Audio::convertMp3($filepath, 128, $outputMp3);
						}

						if(is_file($outputMp3)){
							$updateArray = array(
								'song_file' => 'images/encoded_'.Upload::getName(),
								'song_duration' => $duration );
							unlink($filepath);
						} else {
							$updateArray = array(
								'song_file' => Upload::getFileName('images'),
								'song_duration' => $duration );
						}
						
						$saveMp3 = $songModel->updateId($updateArray, $song_id);

					}


					//UPLOAD SONG COVER
					if($_FILES["image"]["tmp_name"] != '')
						{
							//upload file into uploads folder
							Upload::setName(time());
							Upload::resizeUpload($_FILES["image"],UPLOAD_PATH, '450px');
							
							$update_data = array('song_image' => Upload::getFileName('images'));

							$songModel->updateId($update_data, $song_id);
						}

		}


			if($message == 'ok'){
				Session::set('success','record edited');
				Url::redirect('song/item/'.$_POST['album_id']);
			} else if($message == 'no'){
				$this->data['error'] = 'Operation Fails!';
			}

		$this->data['song'] = \Models\Song::item($song_id);


		View::rendertemplate('header', $this->data);
		View::rendertemplate('sidebar', $this->data);
		View::render('song/song.edit', $this->data);
		View::rendertemplate('footer', $this->data);
	}


	public function delete($parameter){
		$type = $parameter[0];
		$id = $parameter[1];

		if($type == 'album'){
			$model = new \Models\Album;
		} else {
			$model = new \Models\Song;
			$item = $model->find($id);
		}

		$delete = $model->deleteId($id);
		

		if($delete > 0){
			Session::set('success','record deleted!');

			$file = DEL_PATH.$item->song_file;

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

		$model = new \Models\Song;

		if($action == 'deactivate'){
			$update = $model->updateId(	array('song_status_id' => Status::id('inactive') ),$id );
		} else if($action == 'activate'){
			$update = $model->updateId(array('song_status_id'  => Status::id('active') ), $id);
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

		$model = new \Models\Song;
		$status_model = new \models\status;

		
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
