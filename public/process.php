<?php 
	require_once("../includes/initialize.php");

	$action = $_GET['action'];

	switch ($action) {
		case "login":
			$start_page = 'index.php';		
			if($session->is_logged_in()) { redirect_to($start_page);}			
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
			    $user = User::find_by_username($_POST['username']);
			    if($user){
			    	$link = 'login.php?error=2&user='.$user->username;
			    } else {
				    $link = 'login.php?error=1';
			    }
			    redirect_to($link);
			  }
			  
			} else { // Form has not been submitted.
			  $username = "";
			  $password = "";
			}
			break;
		case "logout": 
			$session->logout();
			$link = $_GET['file'] . '/';
    		redirect_to($link);
    		break;
    	case "signup":
			// Test for blank inputs		
			if($_POST['username'] == '') { 
				$link = 'signup.php?error=1&username='.$_POST['username'] . '&firstname=' . $_POST['firstname'] . '&lastname=' . $_POST['lastname'];
				redirect_to($link);
				break;
			}
			if(!checkEmail($_POST['username'])) { 
				$link = 'signup.php?error=5&username='.$_POST['username'] . '&firstname=' . $_POST['firstname'] . '&lastname=' . $_POST['lastname'];
				redirect_to($link);
				break;
			}
			if($_POST['password'] == '') { 
				$link = 'signup.php?error=2&username='.$_POST['username'] . '&firstname=' . $_POST['firstname'] . '&lastname=' . $_POST['lastname'];
				redirect_to($link);
				break;
			}
			if(strlen($_POST['password']) < 4) {
				$link = 'signup.php?error=6&username='.$_POST['username'] . '&firstname=' . $_POST['firstname'] . '&lastname=' . $_POST['lastname'];
				redirect_to($link);
				break;
			}
			if($_POST['firstname'] == '') { 
				$link = 'signup.php?error=3&username='.$_POST['username'] . '&firstname=' . $_POST['firstname'] . '&lastname=' . $_POST['lastname'];
				redirect_to($link);
				break;
			}	
			// Test for registered usernames
			$user = User::find_by_username($_POST['username']);	
			if(!$user){
				User::addUser($_POST['username'], $_POST['password'], '', $_POST['firstname'], $_POST['lastname']);
				$link = 'login.php';
				$new_user = User::authenticate($_POST['username'], $_POST['password']);
				if ($new_user) {
			    	$session->login($new_user);
			    	redirect_to($link);
				}
				break;
			} else {
				$link = 'signup.php?error=4&username='.$_POST['username'] . '&firstname=' . $_POST['firstname'] . '&lastname=' . $_POST['lastname'];
				redirect_to($link);
				break;
			}		
    		break;
		case "create":
			// Create Page 
			$new_page = Page::create_page($_POST['page_name'], $_POST['page_content']);
			$link = $_POST['page_name'] . '/';
			redirect_to($link);
			break;
		case "edit":
			// Edit page
			$page = Page::find($_GET['file']);
			if($page){
				$page->name = $_POST['page_name'];
				$page->content = $_POST['page_content'];
				$page->update();
				$link = $page->name . '/';
			} else {
				$page = Page::create_page($_POST['page_name'], $_POST['page_content']);
				$link = $_POST['page_name'] . '/';
			}
			redirect_to($link);
			break;
		case "delete":
			// Delete page
			$page = Page::find($_GET['file']);
			$page->delete();
			$link = $_GET['file'] . '/';
			redirect_to($link);
			break;
	}
	
	
	


?>