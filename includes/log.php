<?php

require_once(LIB_PATH.DS.'database.php');

class Log extends DatabaseObject {
	
	protected static $table_name = "log";
	protected static $db_fields = array('id', 'log_date', 'log_type', 'content', 'user_id', 'owner_id', 'file_id', 'project_id', 'script_id', 'scene_id', 'element_id', 'asset_id');   
	public $id;
	public $log_date;
	public $log_type;
	public $content;
	public $user_id;
	public $owner_id;
	public $file_id;
	public $project_id;
	public $script_id;
	public $scene_id;
	public $element_id;
	public $asset_id;

	
	public static function message($type='', $content='', $user='', $project='', $script='', $scene='', $element='', $asset='') {
		$log = new Log();
		$log->log_type = $type;
		$log->content = $content;
		$log->user_id = $_SESSION['user_id'];
		$log->project_id = $project;
		$dt = new DateTime("now");
		$date = $dt->format('Y-m-d H:i:sP');
		$log->log_date = $date;
		$log->script_id = $script;
		$log->scene_id = $_GET['scene_id'];
		$log->asset_id =  $asset;
		$log->save();
	}
	
	public static function find_user_logs($user_id='') {
		return static::find_by_sql("SELECT * FROM " . static::$table_name . " WHERE `user_id`=" . $user_id . " ORDER BY `log_date` DESC");
  	}
	
	public static function file_modified($file_id) {
		$permissions = Permission::file_permission_list($file_id);
		foreach($permissions as $permission) {
			$log = new Log();
			$log->log_type = 'file_modified';
			$dt = new DateTime("now");
			$date = $dt->format('Y-m-d H:i:sP');
			$log->log_date = $date;
			$log->user_id = $_SESSION['user_id'];
			$log->file_id = $file_id;
			$log->owner_id = $permission->user_id;
			$log->save();
		}
	}
	
	public static function comment($file_id) {
		$permissions = Permission::file_permission_list($file_id);
		foreach($permissions as $permission) {
			$log = new Log();
			$log->log_type = 'new comment';
			$dt = new DateTime("now");
			$date = $dt->format('Y-m-d H:i:sP');
			$log->log_date = $date;
			$log->user_id = $_SESSION['user_id'];
			$log->file_id = $file_id;
			$log->content = $_POST['comment'];
			$log->owner_id = $permission->user_id;
			$log->save();
		}
	}
	
	public static function last_modified_files(){
		$sql  = "SELECT * FROM log ";
		$sql .= "WHERE log_type = 'file_modified' ";
		$sql .= "AND user_id = '{$_SESSION['user_id']}' ";
		$sql .= " ORDER BY `log_date` DESC";
		$result_array = self::find_by_sql($sql);
		return $result_array;
	}

	public static function last_notifications($number){
		$sql  = "SELECT * FROM log ";
		$sql .= "WHERE owner_id = '{$_SESSION['user_id']}' ";
		$sql .= " ORDER BY `log_date` DESC";
		$sql .= " LIMIT " . $number;
		$result_array = self::find_by_sql($sql);
		return $result_array;
	}
}
