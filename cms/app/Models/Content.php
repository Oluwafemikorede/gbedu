<?php
namespace Models;

use Core\Model;
use Helpers\Database;

class Content extends Model {
	
	public $success;
	public $error;


	protected $table = 'content';

	function __construct(){
		parent::__construct();
		$this->date = date('d-m-Y H:i:s');
	}

	public function detail($id){
		return $this->db->selectRow("SELECT * FROM content 
								  LEFT JOIN page ON page.page_id = content.content_page_id
								  LEFT JOIN category ON category.category_id = page.page_category_id
								  WHERE content.content_id = :id",
								  array('id'=>$id));
	}


	
	
}