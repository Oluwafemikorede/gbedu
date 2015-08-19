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
			$record = $db->selectRow("SELECT * FROM role WHERE role_title = '$title' ");

			return $record->role_id;

		} catch (Exception $e){
			return 0;
		}
	}

}