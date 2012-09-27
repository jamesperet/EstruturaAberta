<?php

require_once(LIB_PATH.DS.'database.php');

class Setting extends DatabaseObject {

	protected static $table_name = "settings";
	protected static $db_fields = array('id','sys_name', 'initial_page');   
	public $id;
	public $sys_name;
	public $initial_page;

	public static function load() {
		$sql  = "SELECT * FROM " . self::$table_name;
		//$sql .= " WHERE id='1'";
		$result_array = self::find_by_sql($sql);
		return !empty($result_array) ? array_shift($result_array) : false;
  }

  	public static function install($sys_name, $initial_page){
		$settings = new Setting();
		$settings->sys_name = $sys_name;
		$settings->initial_page = $initial_page;
		return $settings->save();
	}

}

?>