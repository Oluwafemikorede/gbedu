<?php 
namespace Models;

use Core\Model;
use Helpers\Database;

class Category extends Model {

	protected $table = 'category';
	public $db_helper;
	
	function __construct(){
		parent::__construct();
	}


	public function page(){
		try{
				return $this->db->select("SELECT * FROM $this->table 
										  WHERE category_slug = :slug", 
										  array('slug'=>'page'));
		}
		catch (Exception $e){
			return null;
		}
	}



	static public function section($slug){
		$db = \helpers\database::get();
		try{
				return $db->select("SELECT * FROM category WHERE category_slug = :slug", 
									array('slug'=>$slug));
		}
		catch (Exception $e){
			return null;
		}
	}


	
}