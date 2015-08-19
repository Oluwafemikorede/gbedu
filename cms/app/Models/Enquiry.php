<?php 

namespace models;

use Core\Model;
use Helpers\Database;

class Enquiry extends \core\model {
	
	
	public $table = 'enquiry';

	function __construct(){
		parent::__construct();
	}

	public static function bylimit($limit = ''){
		$db = Database::get();
		try 
		{
			
			return $db->select("SELECT * FROM enquiry 
									  LEFT JOIN status ON status.status_id=enquiry.enquiry_status_id
									  $limit ");

		}
		catch(Exception $e){
			return false;
		}
		
	}

	public static function detail($id){
		$db = Database::get();
		try 
		{
			
			return $db->selectRow("SELECT * FROM enquiry 
									  LEFT JOIN status ON status.status_id=enquiry.enquiry_status_id
									  WHERE enquiry_id = :id",array('id'=>$id));

		}
		catch(Exception $e){
			return false;
		}
		
	}

}