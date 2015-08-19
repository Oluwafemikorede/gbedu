<?php 
namespace Models;

use Core\Model;
use Helpers\Database;
class Smsgroup extends Model {

	protected $table = 'cms_smsgroup';
	
	function __construct(){
		parent::__construct();
	}
	
}