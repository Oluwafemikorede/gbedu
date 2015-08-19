<?php 
namespace Models;

use Core\Model;
use Helpers\Database;

class Playlist extends Model {
	
	
	public $table = 'playlist';

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


  public function items($id, $limit=''){
  		$db = Database::get();
		try
		{
			return $db->select("SELECT * FROM playlist 
								LEFT JOIN song ON song.song_id = playlist.playlist_song_id
								WHERE playlist_album_id = :id $limit",array('id'=>$id));
		} catch (Exception $e){
			return 0;
		}
  }

  public function itemCount($id){
  	$db = Database::get();
		try
		{
			return count($db->select("SELECT * FROM playlist WHERE playlist_album_id = :id",array('id'=>$id)));
		} catch (Exception $e){
			return 0;
		}
  }


  public static function id($title){
		self::getId($title);
	}

}

