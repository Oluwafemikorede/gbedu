<?php 
namespace Models;

use Core\Model;
use Helpers\Database;
use Helpers\Querybuilder;


class Category extends Model {

	protected $table = 'category';
	public $db_helper;
	
	function __construct(){
		parent::__construct();
		$this->db_helper = new Querybuilder;
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

	public function group($limit = null){
		try{
			 return $this->db->select("SELECT * FROM $this->table ORDER BY category_slug $limit");
		}
		catch (Exception $e){
			return null;
		}
	}

	public static function module(){
		$db = Database::get();

		try{
			 return $db->select("SELECT * FROM category GROUP BY category_slug");
		}
		catch (Exception $e){
			return null;
		}
	}

	static public function section($slug){
		$db = Database::get();
		try{
				return $db->select("SELECT * FROM category WHERE category_slug = :slug", 
									array('slug'=>$slug));
		}
		catch (Exception $e){
			return null;
		}
	}

	static public function hasChild($value){
		$db = Database::get();

		$db->select("SELECT * FROM category WHERE category_slug = :val",
					array('val'=>$value));

		return $db->count;
	}

	static public function child($value){
		$db = Database::get();

		return $db->select("SELECT * FROM category WHERE category_slug = :val",	array('val'=>$value));
	}

	static public function row($column, $value)
	{
		$db = Database::get();
		try
		{
				return $db->select("SELECT * FROM category WHERE $column = :val ",  array('val'=>$value));

		} catch(Exception $e){
			return false;
		}
	}


	static public function id($column, $value)
	{
		$db = Database::get();
		try
		{
				$rec = $db->selectRow("SELECT * FROM category WHERE $column = :val ",  array('val'=>$value));
				return $rec->category_id;

		} catch(Exception $e){
			return false;
		}
	}

	
	

	
}