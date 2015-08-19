<?php 
namespace Models;

use Core\Model;
use Helpers\Database;
use Helpers\Querybuilder;

class User extends Model {
	public $query;
	public $error;


	protected $table = 'user';

	function __construct(){
		parent::__construct();
		$this->query = new Querybuilder;


		$this->date = date('d-m-Y H:i:s');
	}


	public function allUsers($limit = ''){
		try
		{
			$myquery = $this->query->table('user')
						->leftjoin('role', 'role.role_id', '=', 'user.user_role_id')
						->get($limit);

			return $myquery;
		}
		catch(Exception $e){
			return null;
		}
	}


	public static function artist($limit = ''){
		$db = Database::get();

		try
		{
			return $db->select("SELECT * FROM user 
									  LEFT JOIN role ON role.role_id = user.user_role_id 
									  LEFT JOIN status ON status.status_id = user.user_status_id 
									  WHERE role.role_title = :title $limit",
									  array('title'=>'artist'));
		}
		catch(Exception $e){
			return null;
		}
	}

	public static function byId($id){
		$db = Database::get();
		
		try
		{
			return $db->selectRow("SELECT * FROM user WHERE user_id = :id ", array('id'=>$id));
		}
		catch(Exception $e){
			return null;
		}
	}



	public function login($email, $password){
		try
		{
			return $this->query->table('user')
							->leftjoin('role', 'role.role_id', '=', 'user.user_role_id')
							->where('user.user_email','=',$email)
							->where('user.user_password','=',$password)
							->where('role.role_title','=','admin')
							->getRow();

			// return $myquery;
		}
		catch(Exception $e){
			return null;
		}
	}


	
}