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
class Sms extends Controller{

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
		
		$sms_model = new \models\sms;
		$smsgroup_model = new \models\smsgroup;


		$this->data['groups'] = $smsgroup_model->all();

		$this->data['title'] = 'SMS';

		if(isset($_POST) && !empty($_POST)){
			$group_id = $_POST['group_id'];
			$message = $_POST['content'];
			$sender = 'TheWorkCourt';
			
			$subscribers = $sms_model->get(array('group_id'=>$group_id));

			foreach($subscribers as $item){
				echo $item->phone."<br>";
			    \helpers\document::sendSMS($sender, $item->phone, $message);
			}
					
			$this->data['success'] = 'SMS Sent!';
		}


		View::rendertemplate('home_header', $this->data);
		View::rendertemplate('sidebar', $this->data);
		View::render('sms/sms', $this->data);
		View::rendertemplate('footer', $this->data);
	} 


	public function add(){
		$action = $_GET['action'];
		$sms_model = new \models\sms;
		$smsgroup_model = new \models\smsgroup;


		$this->data['groups'] = $smsgroup_model->all();

		$this->data['title'] = 'SMS';

		if(isset($_GET['edit'])){
			$find_id = $_GET['ed_id'];
				}

		
		if(isset($_POST) && !empty($_POST)){

				$group_id = $_POST['group_id'];

				if(!empty($_POST['firstname']) && !empty($_POST['lastname'])){

				$firstname = $_POST['firstname'];
				$lastname = $_POST['lastname'];
				$phone = $_POST['phone'];

				$insert_single_sms_array = array(
							'group_id'=>$group_id,'firstname'=>$firstname,'lastname'=>$lastname,'phone'=>$phone);


				if(isset($_GET['edit'])){
					// EDIT OLD RECORD
					// $update_sms_array = array('');
					$where_sms_array = array('id'=>$_GET['ed_id']);
					$update_sms = $sms_model->update($insert_single_sms_array, $where_sms_array);

					$find_id = $_GET['ed_id'];

						if($update_sms > 0)
							$this->data['success'] = 'Record edited successfully!';
					    else 
							$this->data['error'] = 'Operation Fails';

				} else {

						$insert_single_sms_id = $sms_model->create($insert_single_sms_array);

						if($insert_single_sms_id > 0)
							$this->data['success'] = 'Record added successfully!';
					    else 
							$this->data['error'] = 'Operation Fails';


						$find_id = $insert_single_sms_id;

					}

			}
					
			if(isset($_FILES) && !empty($_FILES)){
				if($_FILES["excel"]["tmp_name"] != '')
						{
							//upload excel into uploads folder
							\helpers\upload::setName(uniqid());
							\helpers\upload::upload_file($_FILES["excel"],EXCEL_PATH);

							// $exc = APPPATH.DS.'nfiu.xls';
							$excelpath = EXCEL_PATH.\helpers\upload::$filename;

							$excel_reader = new \helpers\excel\Excel_reader;
							$excel_reader->setOutputEncoding('CP1251');

							$excel_reader->read($excelpath);

							// Get the contents of the first worksheet
							$worksheet = $excel_reader->sheets[0];
							$numRows = $worksheet['numRows']; // ex: 14
							$numCols = $worksheet['numCols']; // ex: 4
							$cells = $worksheet['cells']; // the 1st row are usually the field's name	

							//ADD 1 TO numRows
							$loop_rows = 1 + $numRows;
						
						
							$i=2; while($i < $loop_rows){
								$firstname =  $cells[$i][1];
								$lastname =  $cells[$i][2];
								$phone =  $cells[$i][3];

							
							$insert_array = array(
								'group'=>$group,'firstname'=>$firstname,'lastname'=>$lastname,'phone'=>$phone);
							$insert_sms_id = $sms_model->create($insert_array);	
							//INCREMENT COUNTER
							$i++;
							}

							if($insert_sms_id > 0){
								$this->data['success'] = 'Excel Uploaded successfully!';
							} else {
								$this->data['error'] = 'Operation Fails';
							}
			
			} //CLOSE FILE UPLOAD SCRIPT

		}

		}

		$this->data['smsdata'] = $sms_model->find($find_id);


		View::rendertemplate('home_header', $this->data);
		View::rendertemplate('sidebar', $this->data);
		View::render('sms/sms.addphone', $this->data);
		View::rendertemplate('footer', $this->data);
	}


	public function group(){
		$action = $_GET['action'];
		$smsgroup_model = new \models\smsgroup;
		// $user_model = new \models\users;

		if(isset($_GET['delete'])){
			$delete = $this->smsgroup_model->delete(array('id'=>$_GET['del_id']));

			if($delete > 0){
				$this->data['success'] = 'Record Deleted!';
			} else {
				$this->data['error'] = 'Operation Fails';
			}
		}

		$this->data['title'] = 'SMS Group';

		$find_id = $_GET['ed_id'];

		
		if(isset($_POST) && !empty($_POST)){
			$title = $_POST['title'];
			$description = $_POST['description'];

			$insert_grp_array = array('title'=>$title,'description'=>$description);


		if(isset($_GET['edit'])){
			// EDIT OLD RECORD
			$where_array = array('id'=>$_GET['ed_id']);
			$update_grp = $smsgroup_model->update($insert_grp_array, $where_array);

			$find_id = $_GET['ed_id'];

			$msg_id = $update_grp;
		} else {
			// INSERT NEW RECORD
			$insert_grp_id = $smsgroup_model->create($insert_grp_array);

			$find_id = $insert_grp_id;

			$msg_id = $insert_grp_id;
		}

			if($msg_id > 0)
				$this->data['success'] = 'Record Saved!';
			else
				$this->data['error'] = 'Operation Fails';
		}

		$this->data['record'] = $smsgroup_model->find($find_id);
		$this->data['groups'] = $smsgroup_model->all();


		View::rendertemplate('home_header', $this->data);
		View::rendertemplate('sidebar', $this->data);
		View::render('sms/sms.addgroup', $this->data);
		View::rendertemplate('footer', $this->data);
	}


	public function view($param){
		$sms_model = new \models\sms;
		$smsgroup_model = new \models\smsgroup;

		$user = new \models\users;

		

		if(isset($action) && !empty($action)){
			switch ($action) {
				case 'delete':
					$where_array = array('id'=>$action_id);
					$delete = $sms_model->delete($where_array);

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
				$this->data['success'] = 'Record Deleted!';
			} else if($message == 'no'){
				$this->data['error'] = 'Operation Fails!';
			}

	
	
		$total = count($sms_model->allsms());

		$pages = new \helpers\paginator('6','p');
		$this->data['sms'] = $sms_model->allsms($pages->get_limit());
		$pages->set_total($total);
		$path = DIR.'sms/view?';  
		$this->data['page_links'] = $pages->page_links($path,null);

		$this->data['title'] = 'Users';

		View::rendertemplate('home_header', $this->data);
		View::rendertemplate('sidebar', $this->data);
		View::render('sms/sms.all', $this->data);
		View::rendertemplate('footer', $this->data);
	}

}
