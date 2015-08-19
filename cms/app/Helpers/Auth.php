<?php 
namespace Helpers;

use Helpers\Url;
use Helpers\Session;

/*
 * Document Helper - collection of methods for working with documents
 *
 * @author David Carr - dave@daveismyname.com - http://www.daveismyname.com
 * @version 1.0
 * @date June 27, 2014
 */
class Auth {

	/**
	 * group types into collections, its purpose is to assign the passed extension to the suitable group
	 * @param  string $extension file extension
	 * @return string            group name
	 */
	public static function redirect(){
				if(Session::get('user_id') != '')
					Url::redirect('dashboard');		
	}

	public static function block(){
				if(Session::get('user_id') == ''){
						Url::redirect('account/login');	
						return true;
				}
	}

	public static function authRole($role){
		//CHECK IF USER IS LOGGED IN
		self::block();

		$user = Session::get('user');

		if($user->role != $role){
			// var_dump($user->role);
			Url::redirect('home');	
		}						
	}

}
