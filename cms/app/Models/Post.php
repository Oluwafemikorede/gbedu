<?php 
namespace Models;

use Core\Model;
use Helpers\Database;

class Post extends Model {

	protected $table = 'post';
	
	function __construct(){
		parent::__construct();
	}


	public function bylimit($limit = null){
		try 
		{
			
			return $this->db->select("SELECT * FROM post 
									  LEFT JOIN category ON category.category_id=post.post_category_id
									  LEFT JOIN user ON user.user_id = post.post_user_id
									  LEFT JOIN album ON album.album_id = post.post_album_id
									  $limit ");

		}
		catch(Exception $e){
			return false;
		}
		
	}


	public function getItem($id){
		try 
		{
			return $this->db->selectRow("SELECT * FROM post 
									    LEFT JOIN category ON category.category_id=post.post_category_id
									    LEFT JOIN user ON user.user_id = post.post_user_id
									    LEFT JOIN album ON album.album_id = post.post_album_id
									    WHERE post.post_id = :id",
									    array('id' => $id));
		}
		catch(Exception $e){
			return false;
		}
		
	}


	public static function group($category_slug, $limit){
		$db = Database::get();
		try
		{
			return $db->select("SELECT * FROM post 
								  LEFT JOIN category ON category.category_id=post.post_category_id
								  LEFT JOIN user ON user.user_id = post.post_user_id
								  LEFT JOIN album ON album.album_id = post.post_album_id
								  WHERE category.category_slug = :slug  $limit",
								  array('slug'=>$category_slug));
		}
		catch(Exception $e){

		}
	}


	public static function category($category_title, $category_slug, $limit=''){
		$db = Database::get();
		
		// $id = self::getId($category_title, $category_slug);
		try
		{
			return $db->select("SELECT * FROM post 
								  LEFT JOIN category ON category.category_id=post.post_category_id
								  LEFT JOIN user ON user.user_id = post.post_user_id
								  LEFT JOIN album ON album.album_id = post.post_album_id
								  WHERE category.category_slug = :slug  
								  AND   category.category_title = :title $limit",
								  array('slug'=>$category_slug,'title'=>$category_title));
		}
		catch(Exception $e){

		}
	}


	public static function getId($title,$group = ''){
  	$db = Database::get();

  	if(isset($group) && $group != ''){
  		$append = "AND category_slug = '".$group."'";
  	}
		try
		{
			$record = $db->selectRow("SELECT * FROM category WHERE category_title = '$title' $append");

			return $record->category_id;

		} catch (Exception $e){
			return 0;
		}
  }

	
}