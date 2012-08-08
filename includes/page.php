<?php

require_once(LIB_PATH.DS.'database.php');

class Page extends DatabaseObject {

	protected static $table_name = "pages";
	protected static $db_fields = array('id', 'name', 'content');   
	public $id;
	public $name;
	public $content;

	public static function find($file_name) {
		$sql  = "SELECT * FROM " . self::$table_name;
		$sql .= " WHERE name='". $file_name . "'";
		$result_array = self::find_by_sql($sql);
		return !empty($result_array) ? array_shift($result_array) : false;
  }

}