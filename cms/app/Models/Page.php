<?php 
namespace Models;

use Core\Model;
use Helpers\Database;

class Page extends Model {
	
	public $success;
	public $error;


	protected $table = 'page';

	function __construct(){
		parent::__construct();
		$this->date = date('d-m-Y H:i:s');
	}

	public function allPages(){
		return $this->db->select("SELECT * FROM page 
								  LEFT JOIN category ON category.category_id=page.page_category_id
								  ORDER BY page.page_name ASC");
	}

	public function pages_contents_mainlink(){
		return $this->db->select("SELECT * FROM page 
								  LEFT JOIN category ON category.category_id=page.page_category_id
								  LEFT JOIN content ON content.content_page_id=page.page_id
								  WHERE category.category_title='mainlink'
								  ORDER BY content.content_id ASC");

	}

	public function detail($edit_id){
		return $this->db->selectRow("SELECT * FROM page 
								  LEFT JOIN category ON category.category_id=page.page_category_id
								  LEFT JOIN content ON content.content_page_id=page.page_id
								  WHERE page.page_id = :id",
								  array('id'=>$edit_id));

	}


	public function parent_page(){
		return $this->db->select("SELECT * FROM page 
								  LEFT JOIN category ON category.category_id=page.page_category_id
								  WHERE category.category_title='mainlink'
								  ORDER BY page.page_id ASC");
	}

	public function pages_contents($limit = null){
		$mainlink = $this->db->select("SELECT * FROM page 
								  LEFT JOIN category ON category.category_id=page.page_category_id
								  LEFT JOIN content ON content.content_page_id=page.page_id
								  WHERE category.category_title='mainlink'
								  ORDER BY content.content_id ASC $limit");

		// var_dump($mainlink);

		if(count($mainlink) > 0) {

		foreach($mainlink as $item){
			$sublink = $this->db->select("SELECT * FROM page 
								  LEFT JOIN category ON category.category_id=page.page_category_id
								  LEFT JOIN content ON content.content_page_id=page.page_id
								  WHERE category.category_title='sub-link' 
								  -- OR category.category_title='mainlink' 
								  AND content.content_subto='$item->page_id'
								  ORDER BY content.content_id DESC");

			// var_dump(count($sublink));

			if(count($sublink) > 0){
				$record[] = $item;
				foreach ($sublink as $value) {
				 	$record[] = $value;
				 } 
			} else {
				$record[] = $item;
			}

		}

	} else {
		$record[] = '';
	}

		// var_dump($record);

		return $record;
	}


	public static function pages_contents_sublink($pageid){
		$db = new \helpers\database;
		return $db->select("SELECT * FROM page 
						  LEFT JOIN category ON category.category_id=page.page_category_id
						  LEFT JOIN content ON content.content_page_id=page.page_id
						  WHERE category.category_title='sub-link' 
						  AND content.content_subto=:id
						  ORDER BY content.content_id DESC",
						  array('id'=>$pageid));

	}


	
	
}