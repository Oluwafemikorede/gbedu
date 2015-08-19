<?php 
namespace Models;

use Core\Model;
use Helpers\Database;

class Media extends Model {

	protected $table = 'media';
	
	function __construct(){
		parent::__construct();
	}

	public function getAlbumItems($album_id,$user_id=''){

		if(isset($user_id) && !empty($user_id)){
			$extra = 'AND media.media_user_id = :user_id';
			$array = array('id'=>$album_id,'user_id'=>$user_id);
		} else {
			$array = array('id'=>$album_id);
		}

		return $this->db->select("SELECT *  FROM media 
								 LEFT JOIN status ON status.status_id=media.media_status_id
								 LEFT JOIN category ON category.category_id=media.media_category_id
								 LEFT JOIN album ON album.album_id=media.media_album_id 
								 WHERE album.album_id = :id $extra", 
								 $array);
	}


	public function albumItems($album_id,$limit=''){

		return $this->db->select("SELECT *  FROM media 
								 LEFT JOIN status ON status.status_id=media.media_status_id
								 LEFT JOIN category ON category.category_id=media.media_category_id
								 LEFT JOIN album ON album.album_id=media.media_album_id 
								 WHERE album.album_id = :id 
								 ORDER BY media.media_id DESC $limit", 
								 array('id'=>$album_id));
	}

	public function media($type, $limit = ''){
		try 
		{
			return $this->db->select("SELECT *  FROM media 
								 LEFT JOIN status ON status.status_id=media.media_status_id
								 LEFT JOIN category ON category.category_id=media.media_category_id
								 LEFT JOIN album ON album.album_id=media.media_album_id 
								 WHERE status.status_title = :status
								 AND category.category_title = :media
								 ORDER BY media.media_id DESC $limit",
								 array('status'=>'active', 'media'=>$type));
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
				return $db->selectRow("SELECT * FROM media 
									 LEFT JOIN user ON user.user_id = media.media_user_id
								 	 LEFT JOIN category ON category.category_id=media.media_category_id
				 					 LEFT JOIN status ON status.status_id = media.media_status_id
				 					 WHERE $column = :val ",array('val'=>$value));
			} else {
				return $db->select("SELECT * FROM device 
									LEFT JOIN user ON user.user_id = media.media_user_id
				 					LEFT JOIN status ON status.status_id = media.media_status_id
				 					LEFT JOIN category ON category.category_id=media.media_category_id
				 					WHERE $column = :val ",array('val'=>$value));
			}

		} catch(Exception $e){
			return false;
		}
	}
	

	
}