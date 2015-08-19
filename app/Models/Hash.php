<?php 
namespace Models;

use Core\Model;
use Helpers\Database;

class Hash extends Model {
	
	
	public $table = 'hash';

	function __construct(){
		parent::__construct();
	}

	public function check($slug){
		try 
		{
			return $this->db->select_row("SELECT * FROM hash 
										  LEFT JOIN status ON status.status_id = hash.hash_status_id
										where hash.hash_value = :hash 
										and status.status_title = :status",
										array('hash'=>$slug,'status'=>'active'));
		} catch(Exception $e){
			return false;
		}
	}

}