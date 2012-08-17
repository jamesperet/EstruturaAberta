<?php
require_once("../includes/initialize.php");

$start_page = 'index.php';


if($session->is_logged_in()) {
  redirect_to($start_page);
}

// Remember to give your form's submit tag a name="submit" attribute!
if (isset($_POST['username'])) { // Form has been submitted.

  $username = trim($_POST['username']);
  $password = trim($_POST['password']);
  
  // Check database to see if username/password exist.
	$found_user = User::authenticate($username, $password);
	
  if ($found_user) {
    $session->login($found_user);

    redirect_to($start_page);
  } else {
    // username/password combo was not found in the database
    $message = '<div id="error">Login failed</div>';
    echo $message;
  }
  
} else { // Form has not been submitted.
  $username = "";
  $password = "";
}



?>