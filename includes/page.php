<?php

require_once(LIB_PATH.DS.'database.php');

class Page extends DatabaseObject {

	protected static $table_name = "pages";
	protected static $db_fields = array('id', 'name', 'content', 'creator_id', 'creation_date');   
	public $id;
	public $name;
	public $content;
	public $creator_id;
	public $creation_date;

	public static function find($file_name) {
		$sql  = "SELECT * FROM " . self::$table_name;
		$sql .= " WHERE name='". $file_name . "'";
		$result_array = self::find_by_sql($sql);
		return !empty($result_array) ? array_shift($result_array) : false;
  }
  
  	public static function create_page($file, $content){
		$new_page = new Page();
		$new_page->name = $file;
		$new_page->content = $content;
		$new_page->creator_id = $_SESSION['user_id'];;
		$new_page->creation_date = timeNow();
		return $new_page->save();
	}

}

?>