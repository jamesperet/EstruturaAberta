<?php

require_once(LIB_PATH.DS.'database.php');

class Page extends DatabaseObject {

	protected static $table_name = "pages";
	protected static $db_fields = array('id', 'name', 'content', 'creator_id', 'creation_date', 'parent_id', 'page_type', 'object_id');   
	public $id;
	public $name;
	public $content;
	public $creator_id;
	public $creation_date;
	public $parent_id;
	public $page_type;
	public $object_id;

	public static function find($file_name, $parent_id=0) {
		$sql  = "SELECT * FROM " . self::$table_name;
		$sql .= " WHERE name='". $file_name . "' AND ";
		$sql .= " parent_id='". $parent_id . "'";
		$result_array = self::find_by_sql($sql);
		return !empty($result_array) ? array_shift($result_array) : false;
  }
  
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


}

?>