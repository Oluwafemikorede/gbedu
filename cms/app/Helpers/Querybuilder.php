<?php 
namespace Helpers;

/*
 * quweryBuilder Helper - extending PDO to use custom methods
 *
 * @author Oluwafemi Korede - oluwafemikorede@gmail.com - http://www.oluwakorede.com
 * @version 2.1
 * @date February 1, 2015
 */
class Querybuilder{
	
	/**
	 * @var array Array of saved databases for reusing
	 */
	protected $where_query;
	protected $leftjoin;
	protected $get;
	protected $db;
	protected $selectColumns;
	protected $mainTable;
	protected $rawsql;

	/**
	 * create database connection based 
	 * 
	 */
	public function __construct(){
		//connect to databse here.
		$this->db = \helpers\database::get();
	}


	/**
	 * select columns to be displayed  
	 * 
	 */
	public function selectColumn($qualified_columns){
		
		$this->selectColumns = $qualified_columns;

		return $this;
	}


	public function table($table){
		
		$this->mainTable = $table;

		return $this;
	}

	public function where($operand,$operator,$operand2){
		if(isset($this->where_query) && !empty($this->$where_query)){
			$this->where_query .= " AND ".$operand." ".$operator." '".$operand2."'";
		} else if(!isset($this->where_query) && empty($this->$where_query)){
			$this->where_query = "WHERE ".$operand." ".$operator." '".$operand2."'";
		}

		return $this;
	}

	public function leftjoin($table, $table_column1, $condition, $table_column2){
			$this->leftjoin .= "LEFT JOIN `".$table."` ON ".$table_column1." ".$condition." ".$table_column2." ";

			return $this;
	}

	// GET RAW QUERY
	public function rawquery(){
		return $this->rawsql;
	}


	public function get($limit = ''){
		if(isset($this->leftjoin) && !empty($this->leftjoin)){
			$leftjoin = $this->leftjoin;
		}


		if(isset($this->where_query) && !empty($this->where_query)){
			$where_query = $this->where_query;
		}

		if(isset($this->selectColumns) && !empty($this->selectColumns)){
			$selectColumns = $this->selectColumns;
		} else {
			$selectColumns = "*";
		}


		// var_dump($this->where_query);

			$this->rawsql = "SELECT $selectColumns FROM ".$this->mainTable." $leftjoin  $where_query  $limit";
			// var_dump($this->rawsql);

			$this->cleanMembers(); //

			return $this->db->select($this->rawsql);
	}

	public function getRow(){
		if(isset($this->leftjoin) && !empty($this->leftjoin)){
			$leftjoin = $this->leftjoin;
		}

		if(isset($this->selectColumns) && !empty($this->selectColumns)){
			$selectColumns = $this->selectColumns;
		} else {
			$selectColumns = "*";
		}

		if(isset($this->where_query) && !empty($this->where_query)){
			$where_query = $this->where_query;
		}

			$this->rawsql = "SELECT $selectColumns FROM ".$this->mainTable."   $leftjoin $where_query";

			$this->cleanMembers(); 

			return $this->db->selectRow($this->rawsql);
	}

	public function cleanMembers(){
		$this->leftjoin = '';
	}

	public function first(){
		if(isset($this->leftjoin) && !empty($this->leftjoin)){
			$leftjoin = $this->leftjoin;
		}

		if(isset($this->selectColumns) && !empty($this->selectColumns)){
			$selectColumns = $this->selectColumns;
		} else {
			$selectColumns = "*";
		}

		if(isset($this->where_query) && !empty($this->where_query)){
			$where_query = $this->where_query;
		}

			$this->rawsql = "SELECT $selectColumns FROM ".$this->mainTable."   $leftjoin";

			return $this->db->selectRow("SELECT $selectColumns FROM ".$this->mainTable."   $leftjoin $where_query");
	}

	public function max(){

	}

	public function min(){
		
	}
}
