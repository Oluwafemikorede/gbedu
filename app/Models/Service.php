<?php 

namespace Models;

use Core\Model;
use Helpers\Database;

class Service extends Model {
	
	
	public $table = 'service';

	function __construct(){
		parent::__construct();
	}

}