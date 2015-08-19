<?php 
namespace Models;

use Core\Model;
use Helpers\Database;

class Status extends Model {
	
	
	public $table = 'status';

	function __construct(){
		parent::__construct();
	}

	public static function id($title){
  		$db = Database::get();

		try
		{
			$record = $db->selectRow("SELECT * FROM status WHERE status_title = '$title' ");

			return $record->status_id;

		} catch (Exception $e){
			return 0;
		}
  }

}