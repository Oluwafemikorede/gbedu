<?php
namespace Models;

use Helpers\Database;
use Core\Model;

class Page extends Model
{
	
	public $success;
	public $error;
	public $toplink2;
	public $num_rows;
	public $topPage;
	static public $pageName;
	static public $subName;
	static public $pagedetails;
	static public $controller;
	static public $method;
	static public $parameter;


	protected $table = 'page';

	function __construct(){
		parent::__construct();
	}


	static public function cmsPage(){
		$db = Database::get();

		$uri = parse_url($_SERVER['QUERY_STRING'], PHP_URL_PATH);
		$uri = trim($uri, ' /');
		$parts = explode('/', $uri);

	
		if($parts[0])
			$controller = $parts[0];
		if($parts[1])
			$action = $parts[1];
		if($parts[2])
			$actionid = $parts[2];

		self::$controller = $controller;
		self::$method = $action;
		self::$parameter = $actionid;


		$char_position = strpos($controller,'&');
		if ($char_position > 0 ) {
			$ctp = explode('&', $controller);
			$controller = $ctp[0];
		}

		if($controller == ''){
			$controller = 'home';
		}


		$page = $db->selectRow("SELECT * FROM page WHERE page_alias = '$controller'");

		self::$pageName = $page->page_name;

		
		if(isset($controller) && $action == null){
			$subpage = $db->selectRow("SELECT *	FROM page WHERE page_alias = '$controller'");
			} else if($action != null) {
					$subpage = $db->selectRow("SELECT * FROM page WHERE page_alias = '$action'");
		        } 
		
		self::$subName = $subpage->page_name;

		if(isset($actionid) && $actionid != null) {
			$pagecontent = $db->selectRow("SELECT * FROM page
									  	  LEFT JOIN page_content ON page_content.page_content_page_id = 
									  	  page.page_id 
									      WHERE page.page_alias=:id", 
									      array('id'=>$actionid)); 
		}
		elseif(isset($action) && $action != null && !isset($actionid) && $actionid == null) {
		$pagecontent = $db->selectRow("SELECT * FROM page
								  	  LEFT JOIN page_content ON page_content.page_content_page_id = 
								  	  page.page_id
								      WHERE page.page_alias=:id", 
								      array('id'=>$action)); 
		} 
		elseif(isset($controller) && !isset($action) && $action == null ){
		$pagecontent = $db->selectRow("SELECT * FROM page 
			LEFT JOIN page_content ON page_content.page_content_page_id = page.page_id
			WHERE page.page_alias=:ct", array('ct'=>$controller));
		} 

		self::$pagedetails = $pagecontent;
	}

	static public function getPageDetails(){
		if(isset(self::$pagedetails))
			return self::$pagedetails;
		else
			return false;
	}

	static public function getPageName(){
		if(isset(self::$pageName))
			return self::$pageName;
		else
			return false;
	}

	static public function getSubName(){
		if(isset(self::$subName))
			return self::$subName;
		else
			return false;
	}



	static public function mainLinks(){
		$db = Database::get();

		return $db->select("SELECT * FROM page 
								  LEFT JOIN category ON category.category_id=page.page_category_id
								  LEFT JOIN page_content ON page_content.page_content_page_id=page.page_id
								  WHERE category.category_title='mainlink'
								  AND category.category_SLUG='page'
								  ORDER BY page_content.page_content_sort_order ASC");

	}

	

	static public function cmsRoute(){
		$db = Database::get();

		$uri = parse_url($_SERVER['QUERY_STRING'], PHP_URL_PATH);
		$uri = trim($uri, ' /');
		$parts = explode('/', $uri);


		if($parts[0])
			$controller = $parts[0];
		if($parts[1])
			$action = $parts[1];
		if($parts[2])
			$param = $parts[2];


		$db->selectRow("SELECT * FROM page WHERE page_alias ='$controller'");
		return $db->count;
	}

	static public function mainlinkContent($limit = null){
		$db = \helpers\database::get();

		return $db->select("SELECT * FROM page 
					  	   LEFT JOIN category ON category.category_id=page.page_category_id
						   LEFT JOIN page_content ON page_content.page_content_page_id=page.page_id
						   LEFT JOIN album ON album.album_id=page_content.page_content_album_id
						   WHERE category.category_title= :sectn 
						   AND category.category_slug=:group
						   ORDER BY page_content.page_content_id ASC $limit",
					       array('sectn'=>'mainlink','group'=>'page'));
	}   

	static public function isSublink($page_id){
		$db = \helpers\database::get();
		return $db->selectRow("SELECT * FROM page 
						   LEFT JOIN page_content ON page_content.page_content_page_id=page.page_id
					  	   LEFT JOIN category ON category.category_id=page.page_category_id
						   WHERE category.category_slug=:group 
						   AND page_content.page_content_subto= :id",
					       array('group'=>'page','id'=>$page_id));
		
	}


	public function pages_contents($limit = null){
		$mainlink = $this->db->select("SELECT * FROM page 
								  	   LEFT JOIN category ON category.category_id=page.page_category_id
								  LEFT JOIN page_content ON page_content.page_content_page_id=page.page_id
								  LEFT JOIN album ON album.album_id=page_content.page_content_album_id
								  WHERE category.category_title='mainlink'
								  AND category.category_slug='page'
								  ORDER BY page_content.page_content_id ASC $limit");

		// count($mainlink);

		if(count($mainlink) > 0) {
// var_dump($mainlink);
		foreach($mainlink as $item){
			$sublink = $this->db->select("SELECT * FROM page 
								  LEFT JOIN category ON category.category_id=page.page_category_id
								  LEFT JOIN page_content ON page_content.page_content_page_id=page.page_id
								  LEFT JOIN album ON album.album_id=page_content.page_content_album_id
								  WHERE category.category_title='sub-link' 
								  AND category.category_slug='page'
								  AND page_content.page_content_subto='$item->page_id'
								  ORDER BY page_content.page_content_id DESC");

			if(count($sublink) > 0){
				$record[] = $item;
				foreach ($sublink as $value) {
				 	$record[] = $value;

				 	//check if sublink has subs
				 	$thirdlink = $this->db->select("SELECT * FROM page 
								  LEFT JOIN category ON category.category_id=page.page_category_id
								  LEFT JOIN page_content ON page_content.page_content_page_id=page.page_id
								  LEFT JOIN album ON album.album_id=page_content.page_content_album_id
								  WHERE category.category_title='sub-link' 
								  AND category.category_slug='page'
								  AND page_content.page_content_subto='$value->page_id'
								  ORDER BY page_content.page_content_id DESC");

				 	if(count($thirdlink) > 0){
						foreach ($thirdlink as $value2) {
				 			$record[] = $value2;

				 			//check if thirdlink has subs
				 			// $fourthlink = $this->db->select("SELECT * FROM page 
								//   LEFT JOIN category ON category.category_id=page.page_category_id
								//   LEFT JOIN page_content ON page_content.page_content_page_id=page.page_id
								//   LEFT JOIN album ON album.album_id=page_content.page_content_album_id
								//   WHERE category.category_title='sub-link' 
								//   AND category.category_slug='page'
								//   AND page_content.page_content_subto='$value2->page_id'
								//   ORDER BY page_content.page_content_id DESC");

				 			// if(count($fourthlink) > 0){
								// foreach ($fourthlink as $value3) {
						 	// 		$record[] = $value3;
						 	// 	}
						 	// }
						}
				 	}
				 } 
			} else {
				$record[] = $item;
			}

		}

	} else {
		$record[] = '';
	}


		return $record;
	}


	public static function pages_contents_sublink($pageid){
		$db = \helpers\database::get();
		return $db->select("SELECT * FROM page 
						  LEFT JOIN category ON category.category_id=page.page_category_id
						  LEFT JOIN page_content ON page_content.page_content_page_id=page.page_id
						  LEFT JOIN album ON album.album_id=page_content.page_content_album_id
						  WHERE category.category_title='sub-link' 
						  AND page_content.page_content_subto=:id
						  ORDER BY page_content.page_content_id DESC",
						  array('id'=>$pageid));

	}







	public function topMenu(){
		return $this->db->select("SELECT * FROM page p 
									LEFT JOIN page_content ON page_content.page_content_page_id = page.page_id 
 									LEFT JOIN category ON category.category_id = page.page_category_id
        							WHERE category.category_title = :sectn   
									AND category.category_slug = :group 
									AND page_content.page_content_header_menu = :header 
									ORDER BY page.page_sort_order ASC",
									array('sectn'=>'mainlink','group'=>'page','header'=>'1'));
	}

	


 static public function otherMenu($page_id)
	{
		$db = \helpers\database::get();

        return $db->select("SELECT * FROM page 
        	LEFT JOIN page_content ON page_content.page_content_page_id = page.page_id
        	LEFT JOIN category ON category.category_id = page.page_category_id
        	WHERE category.category_title = :sectn 
			AND category.category_slug = :group 
        	AND page_content.page_content_subto = :subto 
        	AND page_content.page_content_header_menu = :header 
        	ORDER BY page.page_sort_order ASC",
        	array('sectn'=>'sub-link','group'=>'page','subto'=>$page_id,'header'=>1));
     }


public function footerMenu()
	 {
			return $this->db->select("SELECT * FROM page  
				LEFT JOIN page_content ON page_content.page_content_page_id = page.page_id 
				LEFT JOIN category ON category.category_id = page_content.page_content_category_id
				WHERE page_content.page_content_footer_menu= :footer
				AND category.category_slug = :group ",
				array('footer'=>1,'group'=>'page'));
	 }



public function footerMenu2($pageid){
			return $this->db->select("SELECT p.* FROM page p 
								LEFT JOIN page_content c ON c.page_id = p.id  
								LEFT JOIN cms_category cc ON cc.id = p.categoryid
        						WHERE category.category_slug = :group   
        						AND page_content.page_content_footer_menu= :footer 
								AND page_content.page_content_subto=:id ",
								array('footer'=>1,'group'=>'page','id'=>$pageid));
	 }

     


public function singlePage($alias)
    {
       return $this->db->selectRow("SELECT * FROM page 
								     LEFT JOIN page_content  ON page_content.page_content_page_id = page.pageid 
								     WHERE page.page_alias =:alias",
								     array('alias'=>$alias));
    }


public function subPages($alias,$limit = null)
    {
    	$page = $this->db->select_row("SELECT * FROM page WHERE page_alias = '$alias' LIMIT 1");

       	$this->page_alias = $page->page_alias;
       	$this->top_page_alias = $page->page_alias;
       	$this->top_pagename = $page->pagename;

       	if(isset($limit) && $limit != null){
       		$limit = 'LIMIT '.$limit;
       	}

       	
       return $this->db->select("SELECT p.*,c.* FROM page p 
        	LEFT JOIN page_content c ON c.page_id = p.id 
        	WHERE c.subto='".$page->id."' 
        	AND p.id <> '".$page->id."' ORDER BY p.sort_order DESC $limit ");
    }


public function homePage()
	 {		
		 return $this->db->select("SELECT p.pagename,p.page_alias,c.*	FROM page p
							 LEFT JOIN page_content c ON c.pageid = p.id 
							 WHERE c.homepage = '1' 
							 ORDER BY c.sort_order asc");
		
	 }
	

public	function homePageLinks($pageid,$subto,$page_alias)
     {
    	if ($pageid == $subto)
            $this->_pageLinks = '../'.$page_alias;
		else{
		  $row = $this->db->select("SELECT * FROM page WHERE id='".$subto."'");
          
		  $this->_pageLinks = '../'.$row[0]->page_alias.'/'.$page_alias;
		}
     }

	
	
}