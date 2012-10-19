<?php

require_once(LIB_PATH.DS.'database.php');

class ContentType extends DatabaseObject {

	protected static $table_name = "content_types";
	protected static $db_fields = array('id', 'name', 'plugin', 'layout');   
	public $id;
	public $name;
	public $plugin;
	public $layout;

	public static function load($content_type) {
		$sql  = "SELECT * FROM " . self::$table_name;
		$sql .= " WHERE name='". $content_type . "' ";
		$result_array = self::find_by_sql($sql);
		return !empty($result_array) ? array_shift($result_array) : false;
   }


}

?>