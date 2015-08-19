<?php 
namespace Models;

use Core\Model;
use Helpers\Database;

class Postlike extends Model {

	protected $table = 'post_like';
	public $db_helper;
	
	function __construct(){
		parent::__construct();
		$this->db_helper = new \helpers\querybuilder;
	}


	
}