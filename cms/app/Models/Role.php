<?php 
namespace Models;

use Core\Model;
use Helpers\Database;

class Role extends Model {
	
	
	public $table = 'role';

	function __construct(){
		parent::__construct();
	}

	public static function id($title){
		$db = Database::get();
		try
		{
			$rec = $db->selectRow("SELECT * FROM `role` WHERE role_title = :val",array('val'=>$title));

			return $rec->role_id;

		} catch(Exception $e){
			return false;
		}
	}

}