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
			    $message = '<div id="error">Login failed</div>';
			    echo $message;
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