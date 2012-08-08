<?php

require_once(LIB_PATH.DS.'database.php');

class Permission extends DatabaseObject {
	
	protected static $table_name = 'file_permissions';
	protected static $db_fields = array('id', 'file_id', 'user_id', 'permission_type');   
	public $id;
	public $file_id;
	public $user_id;
	public $permission_type;
	
	public static function add_permission($file_id, $user_id, $permission_type=0){
		$new_permission = new Permission();
		$new_permission->file_id = $file_id;
		$new_permission->user_id = $user_id;
		$new_permission->permission_type = $permission_type;
		return $new_permission->save();
	}
	
	public static function check($file_id, $user_id) {
		$sql  = "SELECT * FROM " . self::$table_name;
		$sql .= " WHERE file_id=". $file_id;
		$sql .= " AND user_id=". $user_id;
		$result_array = self::find_by_sql($sql);
		return !empty($result_array) ? array_shift($result_array) : false;
  }
  
  public static function file_permission_list($file_id) {
	  $sql  = "SELECT * FROM " . self::$table_name;
	  $sql .= " WHERE file_id=" . $file_id;
	  $result_array = self::find_by_sql($sql);
	  return $result_array;
  }

}
