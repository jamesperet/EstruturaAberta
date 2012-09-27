<?php

require_once(LIB_PATH.DS.'database.php');

class Tag extends DatabaseObject {

	protected static $table_name = "tags";
	protected static $db_fields = array('id', 'name');   
	public $id;
	public $name;

	public static function new_tag($name) {
		if($name){
			$tag = new Tag();
			$tag->name = $name;
			$tag->save();
		}
	}
	
	public static function find($tag) {
		$sql  = "SELECT * FROM " . self::$table_name;
		$sql .= " WHERE name='". $tag . "'";
		$result_array = self::find_by_sql($sql);
		return !empty($result_array) ? array_shift($result_array) : false;
  }

}