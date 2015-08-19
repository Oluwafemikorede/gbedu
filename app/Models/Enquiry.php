<?php 

namespace Models;

use Core\Model;
use Helpers\Database;

class Enquiry extends Model {
	
	
	public $table = 'enquiry';

	function __construct(){
		parent::__construct();
	}

}