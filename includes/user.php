<?php

require_once(LIB_PATH.DS.'database.php');

class User extends DatabaseObject {
	
	protected static $table_name = "users";
	protected static $db_fields = array('id', 'username', 'password', 'first_name', 'last_name', 'user_email', 'registration_date', 'bio', 'avatar');   
	public $id;
	public $username;
	public $password;
	public $first_name;
	public $last_name;
	public $user_email;
	public $registration_date;
	public $bio;
	public $avatar;
	
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
	
	public static function checkUser() {
		$username = $_POST['username'];
		$password = $_POST['password'];
		$firstname = $_POST['firstname'];	
		$lastname = $_POST['lastname'];
		$email = $_POST['email'];
		// Test for blank inputs		
		if($username == '') { echo 'blank-username-error'; return; }
		if($password == '') { echo 'blank-password-error'; return; }
		if($firstname == '') { echo 'blank-firstname-error'; return; }	
		if($lastname == '') { echo 'blank-lastname-error'; return; }
		if($email == '') { echo 'blank-email-error'; return; }
		// Test for registered usernames				
		global $database;
		$username = $database->escape_value($username);
		$password = $database->escape_value($password);
		$email = $database->escape_value($email);
		$sql1  = "SELECT * FROM users ";
		$sql1 .= "WHERE username = '{$username}' ";
		$sql1 .= "LIMIT 1";
		$result_array = self::find_by_sql($sql1);
		if(empty($result_array)){
			// Test for resgistered emails
			$sql2  = "SELECT * FROM users ";
			$sql2 .= "WHERE user_email = '{$email}' ";
			$sql2 .= "LIMIT 1";
			$result_array2 = self::find_by_sql($sql2);
			if(empty($result_array2)){
				User::addUser($username, $password, $email, $firstname, $lastname);
			} else {
				echo 'invalid-email-error';
			}
		} else {
			echo 'invalid-username-error';
		}
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
		$new_user->save();
		echo "Profile Created";
	}

}

?>