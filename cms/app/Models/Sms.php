<?php 
namespace Models;

use Core\Model;
use Helpers\Database;

class Sms extends Model {

	protected $table = 'cms_sms';
	
	function __construct(){
		parent::__construct();
	}

	public function byGroup(){
		return $this->db->select("SELECT * FROM $this->table GROUP BY `group`");
	}

	public function allsms($limit=null){
		return $this->db->select("SELECT g.title,s.* FROM cms_sms s 
								LEFT JOIN cms_smsgroup g ON g.id=s.group_id
								 ORDER BY g.id $limit");
	}


	
}