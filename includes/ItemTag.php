<?php

require_once(LIB_PATH.DS.'database.php');

class ItemTag extends DatabaseObject {

	protected static $table_name = "tagged_items";
	protected static $db_fields = array('id', 'item_id', 'item_type', 'tag_id');   
	public $id;
	public $item_id;
	public $item_type;
	public $tag_id;

	public static function tag($item_id, $tag_id, $item_type) {
		$sql  = "SELECT * FROM " . static::$table_name . " WHERE `item_id`='" . $item_id . "' AND `item_type`='" . $item_type . "' AND `tag_id`='" . $tag_id . "'";
		$result_array = self::find_by_sql($sql);
		$tag = static::find_by_sql($sql);
		if(!$tag && $tag_id != 0){
			$tag = new ItemTag();
			$tag->item_id = $item_id;
			$tag->tag_id = $tag_id;
			$tag->item_type = $item_type;
			$tag->save();
		}
	}
	
	public static function find($item_id, $item_type) {
		$sql  = "SELECT * FROM " . static::$table_name . " WHERE `item_id`='" . $item_id . "' AND `item_type`='" . $item_type . "'";
		$result_array = self::find_by_sql($sql);
		return static::find_by_sql($sql);
	}
	
	public static function find_object_tag($item_id, $tag_id, $item_type) {
		$sql  = "SELECT * FROM " . static::$table_name . " WHERE `item_id`='" . $item_id . "' AND `item_type`='" . $item_type . "' AND `tag_id`='" . $tag_id . "'";
		$result_array = self::find_by_sql($sql);
		return static::find_by_sql($sql);
	}
	
	public static function count_tags($tag_id){
		$sql  = "SELECT * FROM " . static::$table_name . " WHERE `tag_id`='" . $tag_id . "'";
		$result_array = static::find_by_sql($sql);
		$counter = 0;
		foreach($result_array as $item){
			$counter = $counter + 1;
		}
		return $counter;
	}
}