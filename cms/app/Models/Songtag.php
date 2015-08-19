<?php 
namespace Models;

use Core\Model;
use Helpers\Database;

class Songtag extends Model {
	
	
	public $table = 'songtag';

	function __construct(){
		parent::__construct();
	}

	public static function getId($title){
  		$db = Database::get();

		try
		{
			$record = $db->selectRow("SELECT * FROM status WHERE status_title = '$title' ");

			return $record->status_id;

		} catch (Exception $e){
			return 0;
		}
  }

  public static function id($title){
		self::getId($title);
	}

}