<?php

require_once(LIB_PATH.DS.'database.php');

class User extends DatabaseObject {
	
	protected static $table_name = "users";
	protected static $db_fields = array('id', 'username', 'password', 'first_name', 'last_name', 'user_email', 'registration_date', 'bio', 'avatar', 'user_type');   
	public $id;
	public $username;
	public $password;
	public $first_name;
	public $last_name;
	public $user_email;
	public $registration_date;
	public $bio;
	public $avatar;
	public $user_type;
	
	public static function authenticate($username="", $password="") {
		global $database;
		$username = $database->escape_value($username);
		$password = $database->escape_value($password);
		$sql  = "SELECT * FROM users ";
		$sql .= "WHERE username = '{$username}' ";
		$sql .= "AND password = '{$password} ' ";
		$sql .= "LIMIT 1";
		$result_array = self::find_by_sql($sql);
		return !empty($result_array) ? array_shift($result_array) : false;
	}

	public function full_name() {
    	if(isset($this->first_name) && isset($this->last_name)) {
	    	return $this->first_name . " " . $this->last_name;
	    } else {
		    return "";
		}
	} 
	
	public function username() {
		$user = User::find_by_id($_SESSION['user_id']);
		return $user->username;
	}
	
	public static function addUser($username, $password, $email, $firstname, $lastname) {
		$new_user = New User();
		$new_user->username = $username;
		$new_user->password = $password;
		$new_user->user_email = $email;
		$new_user->first_name = $firstname;
		$new_user->last_name = $lastname;
		$dt = new DateTime("now");
		$date = $dt->format('Y-m-d H:i:sP');
		$new_user->registration_date = $date;
		$new_user->user_type = 'user';
		$new_user->save();
	}
	
	public static function find_by_username($username="") {
		global $database;
		$username = $database->escape_value($username);
		$sql  = "SELECT * FROM users ";
		$sql .= "WHERE username = '{$username}' ";
		$sql .= "LIMIT 1";
		$result_array = self::find_by_sql($sql);
		return !empty($result_array) ? array_shift($result_array) : false;
	}

}

?>