<?php 
namespace Models;

use Core\Model;
use Helpers\Database;

class Song extends Model {

	protected $table = 'song';
	
	function __construct(){
		parent::__construct();
	}

	public function album($album_id, $limit = ''){
		$db = Database::get();
		if(is_numeric($album_id)){ //$album is a primary key or id
			$sql = 'album_id';
		} else {
			$sql = 'album_name';
		}

		try
		{
			return $db->select("SELECT *  FROM song 
							LEFT JOIN album ON album.album_id=song.song_album_id
							LEFT JOIN category as genre ON genre.category_id=song.song_genre_id
							LEFT JOIN user  ON user.user_id=song.song_user_id 
							LEFT JOIN status  ON status.status_id=song.song_status_id 
							WHERE $sql = :val $limit",array('val'=>$album_id)); 
		} catch(Exception $e){
			return false;
		}

		
	}


	public function items($limit='' ){
		$db = Database::get();
		try
		{
			return $db->select("SELECT *  FROM song 
								  LEFT JOIN status ON status.status_id=song.song_status_id
								  LEFT JOIN category ON category.category_id=song.song_genre_id
								  LEFT JOIN album ON album.album_id=song.song_album_id 
								  ORDER BY song.song_id DESC $limit");
		} catch(Exception $e){
			return false;
		}

		
	}


	public function item($id){
		$db = Database::get();
		try
		{
			return $db->selectRow("SELECT *  FROM song 
								  LEFT JOIN status ON status.status_id=song.song_status_id
								  LEFT JOIN category as genre ON genre.category_id=song.song_genre_id
								  LEFT JOIN album ON album.album_id=song.song_album_id 
								  WHERE song_id = :id", array('id'=>$id));
		} catch(Exception $e){
			return false;
		}

		
	}


	public function itemCount($album_id=''){
		$db = Database::get();
		if(is_numeric($album_id)){ //$album is a primary key or id
			$sql = "WHERE song_album_id = '".$album_id."'";
		} else {
			$sql = "WHERE album_slug = '".$album_id."'";
		}
		try
		{
			$re = $db->selectRow("SELECT COUNT(*) as count FROM song 
								  LEFT JOIN album ON album.album_id=song.song_album_id $sql");

			return $re->count;
		} catch(Exception $e){
			return false;
		}

		
	}


	static public function row($column, $value, $count = 0)
	{
		$db = Database::get();
		try
		{
			if($count == 0){
				return $db->selectRow("SELECT * FROM song 
									 LEFT JOIN user ON user.user_id = song.song_user_id
								 	 LEFT JOIN category ON category.category_id=song.song_category_id
				 					 LEFT JOIN status ON status.status_id = song.song_status_id
				 					 WHERE $column = :val ",array('val'=>$value));
			} else {
				return $db->select("SELECT * FROM song 
									LEFT JOIN user ON user.user_id = song.song_user_id
				 					LEFT JOIN status ON status.status_id = song.song_status_id
				 					LEFT JOIN category ON category.category_id=song.song_category_id
				 					WHERE $column = :val ",array('val'=>$value));
			}

		} catch(Exception $e){
			return false;
		}
	}
	

	
}