<?php
namespace Models;

use Core\Model;
use Helpers\Database;

class Album extends Model {

	protected $table = 'album';
	
	function __construct(){
		parent::__construct();
	}

	public function allAlbum($limit =''){
		$db = Database::get();
		try
		{
			return $db->select("SELECT  * from album 
								LEFT JOIN category ON category.category_id = album.album_category_id
								ORDER BY album_id DESC $limit");
		} catch(Exception $e){
			return false;
		}
	}


	public function type($type, $limit =''){
		$db = Database::get();
		try
		{
			return $db->select("SELECT  * from album 
								LEFT JOIN category ON category.category_id = album.album_category_id
								WHERE category_title = :type
								AND category_slug    = 'playlist'
								ORDER BY album_id DESC $limit",array('type'=>$type));
		} catch(Exception $e){
			return false;
		}
	}


	public static function findSlug($title){
		$db = \helpers\database::get();
		try
		{
			$record = $db->select("SELECT * FROM album WHERE album_name = :name ",
									array('name'=>$title));

			return $record->album_id;
			
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
				 					   LEFT JOIN status ON status.status_id = album.album_status_id
				 					   LEFT JOIN category ON type.category_id = album.album_category_id 
				 					   WHERE $column = :val ",
				 					   array('val'=>$value));

		} catch(Exception $e){
			return false;
		}
	}

	static public function id($column, $value)
	{
		$db = Database::get();
		try
		{
				$rec = $db->selectRow("SELECT * FROM album 
									   LEFT JOIN user ON user.user_id = album.album_user_id
				 					   LEFT JOIN status ON status.status_id = album.album_status_id
				 					   LEFT JOIN category ON category.category_id = album.album_category_id 
				 					   WHERE $column = :val ",
				 					   array('val'=>$value));

				return $rec->album_id;

		} catch(Exception $e){
			return false;
		}
	}

	
}