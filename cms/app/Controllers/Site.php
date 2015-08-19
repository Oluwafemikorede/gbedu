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
class Site extends Controller{


	public $site_model;

	/**
	 * call the parent construct
	 */
	public function __construct(){
		parent::__construct();

		$this->language->load('welcome');
		$this->site_model = new \models\site;

	}

	/**
	 * define page title and load template files
	 */
	public function index(){

		$this->data['title'] = 'Site Settings';

		$settings = new \models\sitepreference;

		if(isset($_POST) && !empty($_POST)){

			$title = $_POST['title'];
			$value = $_POST['value'];

			$insert_array = array('preference'=>$title,'value'=>$value);

			$insert_id = $settings->create($insert_array);

			if($insert_id > 0){
				$this->data['success'] = 'Record Added!';
			} else if($message == 'no'){
				$this->data['error'] = 'Operation Fails!';
			}

		}

			

		

		$this->data['settings'] = $settings->all();
		$this->data['site_data'] = $settings->find($insert_id);

		View::rendertemplate('header', $this->data);
		View::rendertemplate('sidebar', $this->data);
		View::render('settings/settings.index', $this->data);
		View::rendertemplate('footer', $this->data);
	} 


	public function settings(){

		$this->data['title'] = 'Site Settings';


		if(isset($_POST) && !empty($_POST)){

			$title = $_POST['title'];
			$value = $_POST['value'];

			$insert_array = array('site_preference'=>$title,'site_value'=>$value);

			$insert_id = $this->site_model->create($insert_array);

			if($insert_id > 0){
				$this->data['success'] = 'Record Added!';

				//UPLOAD ATTACHMENT
					if($_FILES["image"]["tmp_name"] != '')
						{
							//upload image into uploads folder
							\helpers\upload::setName(time());
							\helpers\upload::upload_file($_FILES["image"],UPLOAD_PATH);
							
							$image_name = \helpers\upload::getFileName('images');

							$update_data = array('site_file' => $image_name);
							$where_array = array('site_id'   => $insert_id);

							$this->site_model->update($update_data, $where_array);
						}

			} else if($message == 'no'){
				$this->data['error'] = 'Operation Fails!';
			}

		}

			
		$this->data['settings'] = $this->site_model->all();
		$this->data['site_data'] = $this->site_model->find($insert_id);

		View::rendertemplate('header', $this->data);
		View::rendertemplate('sidebar', $this->data);
		View::render('settings/settings.index', $this->data);
		View::rendertemplate('footer', $this->data);
	} 


	public function savedb(){
		$db_helper = \helpers\database::get();

		$data = $db_helper->dump();

		$save_path = BASE_PATH.DS.'app'.DS.'templates'.DS.'push';

		$openfile = fopen($save_path.DS.'push.sql',"w");
		fwrite($openfile,$data);
		fclose($openfile);
	}


	public function scandir(){
			if(isset($_POST) && !empty($_POST)){
	    	$file = $_POST['pushFile'];
	    	foreach($file as $item){
	    		if($item != '//errorlog.html'){
		    		$file_path[] = BASE_PATH.DS.'app'.$item;
	    		}
	    	}

	    	$destination = BASE_PATH.DS.'app'.DS.'templates'.DS.'push'.DS.'update.zip';
	    	$folderpath = BASE_PATH.DS.'app'.DS;

	    	$zip = \helpers\document::zip($folderpath, $destination, $file_path, true);


	    	}



			$scanner = new \helpers\scanner;
		    
		    $config = $scanner->get_config();

		    $original_cwd = getcwd();


		    if (isset($config['start_dir'])) {
		        chdir($config['start_dir']);
		    }

		    $results = $scanner->scan();

		    if ($results) {
		       $this->data['report'] = 'Scan Results - For '.$results['current_scan']."<br>";
		        unset ($results['current_scan']);
				$count = count($results['Changed']) + count($results['Added']) + count($results['Deleted']);
		        
		        foreach ($results as $key => $entries) {
		            $this->data['report'] .=  $key."<br>";
		                foreach ($entries as $entry){ 
		                    $pushFile = ltrim($entry, '.');
		                     $this->data['report'] .= '<input type="checkbox" class="checkbox1" name="pushFile[]" value="'.$pushFile.'" > '.$pushFile."<br>";
		                }
		            $this->data['report']  .= "<br>";
		        }
		    }
		    chdir($original_cwd);


		View::rendertemplate('header', $this->data);
		View::rendertemplate('sidebar', $this->data);
		View::render('update/push.index', $this->data);
		View::rendertemplate('footer', $this->data);
	}


	public function edit($param){
			$edit_id = $param[0];

		$this->data['title'] = 'Edit Settings';

		if(isset($_POST) && !empty($_POST)){

			$title = $_POST['title'];
			$value = $_POST['value'];
			$slug = \helpers\url::generateSafeSlug($title);

			$update_array = array('site_preference'=>$title,'site_value'=>$value);

			// $update_id = $settings->update($update_array,array('id'=>$edit_id));
			$update_id = $this->site_model->updateId($update_array, $edit_id);

			if($update_id > 0){
				$this->data['success'] = 'Record Updated!';
			} else {
				$$this->data['error'] = 'Operation Fails!';
			}

			if($_FILES["image"]["tmp_name"] != '')
						{
							//upload image into uploads folder
							\helpers\upload::setName(time());
							\helpers\upload::upload_file($_FILES["image"],UPLOAD_PATH);
							
							$image_name = \helpers\upload::getFileName('images');

							$update_data = array('site_file' => $image_name);

							$update_id = $this->site_model->updateId($update_data, $edit_id);
							

							if($update_id > 0)
									$this->data['success'] = 'Record Updated!';
								else
									$$this->data['error'] = 'Operation Fails!';
								
						}

		}


		$this->data['site_data'] = $this->site_model->find($edit_id);

		$this->data['settings'] = $this->site_model->all();

		View::rendertemplate('header', $this->data);
		View::rendertemplate('sidebar', $this->data);
		View::render('settings/settings.index', $this->data);
		View::rendertemplate('footer', $this->data);
	}



	public function delete($param){
		$id = $param[0];

		$delete = $this->site_model->deleteId($id);


		if($delete > 0){
			\helpers\session::set('success','Record Deleted!');
			\helpers\url::redirect('site/settings');
		} else {
			// $this->data['error'] = 'Operation Fails!';
			\helpers\session::set('error','Operation Fails!');
			
		}
	}



}
