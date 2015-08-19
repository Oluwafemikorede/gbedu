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
					Url::redirect('');		
	}

	public static function block(){
				if(Session::get('user_id') == ''){
						$uri = parse_url($_SERVER['QUERY_STRING'], PHP_URL_PATH);
						$uri = trim($uri, ' /');
						$parts = explode('/', $uri);

					
						if(isset($parts[0]) && $parts[0] != '')
							$redirect_url = $parts[0];
						if(isset($parts[1]) && $parts[1] != '')
							$redirect_url = $redirect_url.'/'.$parts[1];
						if(isset($parts[2]) && $parts[2] != '')
							$redirect_url = $redirect_url.'/'.$parts[2];


						Session::set('redirectLogin',$redirect_url);	
						Url::redirect('account/signin');	
						return true;
				}
	}

	public static function role($role){
		$auth = Session::get('user');
				if($auth->role_title != $role){
						Url::redirect('dashboard');	
						return true;
				}
	}

	public static function authRole($role){
		//CHECK IF USER IS LOGGED IN
		self::auth_block();

		$user = Session::get('user');

		if($user->role_title != $role){
			// var_dump($user->role);
			Url::redirect('dashboard');	
		}						
	}

}
