<?php 

namespace Models;

use Core\Model;
use Helpers\Database;

class Task extends Model {
	
	
	public $table = 'task';

	function __construct(){
		parent::__construct();
	}

}