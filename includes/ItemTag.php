<?php

require_once(LIB_PATH.DS.'database.php');

class ItemTag extends DatabaseObject {

	protected static $table_name = "tagged_items";
	protected static $db_fields = array('id', 'item_id', 'item_type', 'tag_id');   
	public $id;
	public $item_id;
	public $item_type;
	public $tag_id;

	public static function tag($item_id, $tag_id) {
		$tag = new ItemTag();
		$tag->item_id = $item_id;
		$tag->tag_id = $tag_id;
		$tag->save();
	}
	
	public static function find($item_id, $item_type) {
		$sql  = "SELECT * FROM " . static::$table_name . " WHERE `item_id`='" . $item_id . "' AND `item_type`='" . $item_type . "'";
		$result_array = self::find_by_sql($sql);
		return static::find_by_sql($sql);
	}

}