<?php

require_once(LIB_PATH.DS.'database.php');

class Tag extends DatabaseObject {

	protected static $table_name = "tags";
	protected static $db_fields = array('id', 'name');   
	public $id;
	public $name;

	public static function new_tag($name) {
		$tag = new Tag();
		$tag->name = $name;
		$tag->save();
	}

}