<?php 
namespace Models;

use Core\Model;
use Helpers\Database;

class User extends Model {
	
	
	public $table = 'user';

	function __construct(){
		parent::__construct();
	}


	public static function login($email, $password){
		$db = Database::get();

		try{
			return $db->selectRow("SELECT * FROM user  
										LEFT JOIN role ON role.role_id=user.user_role_id
										WHERE user.user_email = :email  
										AND user.user_password= :password", 
										array('email'=>$email,'password'=>$password));
		} catch(Exception $e){
			return false;
		}

	}


	public static function byRole($role){
		$db = Database::get();

		try{
			return $db->selectRow("SELECT * FROM user  
										LEFT JOIN role ON role.role_id=user.user_role_id
										WHERE role.role_title = :role",	array('role'=>$role));
		} catch(Exception $e){
			return false;
		}

	}


	public function profile($id){
		$db = Database::get();
		try
		{
			return $db->selectRow("SELECT * FROM user 
								  LEFT JOIN role ON role.role_id=user.user_role_id
								  WHERE user_id = :id ",array('id'=>$id));


		} catch(Exception $e){
			return false;
		}
	}



	

}