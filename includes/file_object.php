<?php

require_once(LIB_PATH.DS.'database.php');

class FileObject extends DatabaseObject {
	
	protected static $table_name = 'files';
	protected static $db_fields = array('id', 'name', 'creation_date', 'file_type', 'object_id', 'parent_id', 'owner_id', 'status', 'visibility');   
	public $id;
	public $name;
	public $creation_date;
	public $file_type;
	public $object_id;
	public $parent_id;
	public $owner_id;
	public $status;
	public $visibility;
	
	public static function add_file($name, $file_type, $object_id=0, $parent_id, $visibility){
		$file = new FileObject();
		$file->name = $name;
		$file->file_type = $file_type;
		$file->object_id = $object_id;
		$file->parent_id = $parent_id;		
		$file->owner_id = $_SESSION['user_id'];	
		$dt = new DateTime("now");
		$date = $dt->format('Y-m-d H:i:sP');
		$file->creation_date = $date;
		$file->visibility = $visibility;
		$file->save();
		Permission::add_permission($file->id, $_SESSION['user_id'], 'delete');
		return $file->id;
	}
	
	public static function find_folder_files($parent_id=0) {
		$sql  = "SELECT * FROM " . self::$table_name;
		$sql .= " WHERE parent_id=". $parent_id;
		$sql .= " ORDER BY `name`";
		return self::find_by_sql($sql);
  }
  
  public static function find_public_folder_files($parent_id=0) {
  		$sql  = "SELECT * FROM " . self::$table_name;
  		$sql .= " WHERE `parent_id`='". $parent_id;
  		$sql .= "' AND `visibility`='public'";
  		$sql .= " ORDER BY `name`";
  		return self::find_by_sql($sql);
  	}

	public static function delete_folder_contents($file_id) {
		$folder_contents = FileObject::find_folder_files($file_id);
		if($folder_contents){
			foreach($folder_contents as $file) {
				FileObject::delete_folder_contents($file->id);
				$file->delete();
			}
		}
	}
	
	public static function find_project_folders() {
			$sql  = "SELECT * FROM " . self::$table_name;
			$sql .= " WHERE file_type='project'";
			$results = self::find_by_sql($sql);
			if($results){
				$object_array = array();
				foreach($results as $project) {		
					$permission = Permission::check($project->id, $_SESSION['user_id']);
					if($permission){					
						$object_array[] = $project;
						}
					}
				return $object_array;
			}
		}

}
