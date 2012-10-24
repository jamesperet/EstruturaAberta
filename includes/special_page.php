<?php

require_once(LIB_PATH.DS.'database.php');

class SpecialPage extends DatabaseObject {

	protected static $table_name = "special_pages";
	protected static $db_fields = array('id', 'name', 'file_name', 'plugin', 'content_type', 'fixed', 'unique', 'function', 'parent');   
	public $id;
	public $name;
	public $file_name;
	public $plugin;
	public $content_type;
	public $fixed;
	public $unique;
	public $function;
	public $parent;



	public static function find_page_by_type($page, $content_type) {
		$sql  = "SELECT * FROM " . self::$table_name;
		$sql .= " WHERE name='". $page . "' AND ";
		$sql .= " content_type='". $content_type . "' AND ";
		$sql .= " fixed='0' ";
		$result_array = self::find_by_sql($sql);
		return !empty($result_array) ? array_shift($result_array) : false;
  }
  
	public static function find_page($page) {
		$sql  = "SELECT * FROM " . self::$table_name;
		$sql .= " WHERE name='". $page . "' AND ";
		$sql .= " parent='0' AND ";
		$sql .= " fixed='0' ";
		$result_array = self::find_by_sql($sql);
		return !empty($result_array) ? array_shift($result_array) : false;
  }

  public static function content_type($page_type) {
		$sql  = "SELECT * FROM " . self::$table_name;
		$sql .= " WHERE content_type='". $page_type . "' AND ";
		$sql .= " function='default'";
		$result_array = self::find_by_sql($sql);
		return !empty($result_array) ? array_shift($result_array) : false;
  }

 
/* 
  	public static function create_page($file, $content, $parent_id=0){
		$new_page = new Page();
		$new_page->name = $file;
		$new_page->content = $content;
		$new_page->creator_id = $_SESSION['user_id'];;
		$new_page->creation_date = timeNow();
		$new_page->parent_id = $parent_id;
		return $new_page->save();
	}

	public static function search($query) {
		$sql  = " SELECT * FROM `pages` WHERE `name` LIKE '%". $query . "%' OR `content` LIKE '%" . $query . "%'";
		$result_array = self::find_by_sql($sql);
		return static::find_by_sql($sql);
	}
*/


}

?>