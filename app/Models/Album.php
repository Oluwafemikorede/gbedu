<?php 
namespace Models;

use Core\Model;
use Helpers\Database;

class Album extends Model {
	
	
	public $table = 'album';

	function __construct(){
		parent::__construct();
	}


	public function name($name){
		try 
		{
			return $this->db->select("SELECT *  FROM album_item 
								 LEFT JOIN status ON status.status_id=album_item.album_item_status_id
								 LEFT JOIN category ON category.category_id=album_item.album_item_category_id
								 LEFT JOIN album ON album.album_id=album_item.album_item_album_id 
								 WHERE album.album_name = :name
								 AND status.status_title = :status",
								 array('name'=>$name,'status'=>'active'));
		} catch(Exception $e){
			return false;
		}
	}
	

	public static function type($type, $limit=''){
		$db = Database::get();
		try
		{
			return $db->select("SELECT * FROM album 
								LEFT JOIN category ON category.category_id = album.album_category_id
								WHERE category_slug = 'playlist' 
								AND category_title  = :title 
								ORDER BY album_id DESC $limit ", array('title'=>$type));

			
		} catch (Exception $e){
			return null;
		}
	}


	static public function row($column, $value)
	{
		$db = Database::get();
		try
		{
				return $db->selectRow("SELECT * FROM album 
									 LEFT JOIN user ON user.user_id = album.album_user_id
				 					 LEFT JOIN category ON category.category_id = album.album_category_id
				 					 WHERE $column = :val ",array('val'=>$value));
		} catch(Exception $e){
			return false;
		}
	}



	public function item($alias){
		try 
		{
			return $this->db->select_row("SELECT *  FROM album_item 
								 LEFT JOIN status ON status.status_id=album_item.album_item_status_id
								 LEFT JOIN category ON category.category_id=album_item.album_item_category_id
								 LEFT JOIN album ON album.album_id=album_item.album_item_album_id 
								 WHERE album_item.album_item_alias = :alias
								 AND status.status_title = :status
								 AND category.category_title = :vid",
								 array('alias'=>$alias,'status'=>'active', 'vid'=>'video'));
		} catch(Exception $e){
			return false;
		}
	}



	public function otherVideos($alias, $limit){
		$item_model = new \models\albumitem;

		if(is_numeric($limit)){
			$descLimit = 'LIMIT 0,'.$limit;
		}

		$albumRec = $this->db->select_row("SELECT *  
										   FROM album_item 
										   WHERE album_item_alias = :alias",
									   		array('alias'=>$alias));

		try 
		{
			return $this->db->select("SELECT *  FROM album_item 
								      LEFT JOIN status ON status.status_id=album_item.album_item_status_id
								 	  LEFT JOIN category ON category.category_id=album_item.album_item_category_id
								 	  LEFT JOIN album ON album.album_id=album_item.album_item_album_id 
								 	  WHERE album_item.album_item_user_id = :id
								 	  AND album_item.album_item_alias != :alias
								 	  AND status.status_title = :status
								 AND category.category_title = :vid 
								 ORDER BY RAND() $descLimit",
								 array('id'=>$albumRec->album_item_user_id,'alias'=>$alias,'status'=>'active', 'vid'=>'video'));
		} catch(Exception $e){
			return false;
		}
	}

}