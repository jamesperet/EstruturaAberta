<?php 
	require_once("includes/initialize.php");

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
			    break;
			  }
			  
			} else { // Form has not been submitted.
			  $username = "";
			  $password = "";
			}
			break;
		case "logout": 
			$session->logout();
			if($_GET['file']){
				$link = $_GET['file'] . '/';
			} else {
				$link = "index.php";
			}
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
			    	$message = MailTemplate('welcome.php');
			    	$settings = Setting::load();
			    	sendMail($new_user->username, $settings->email, 'Welcome', $message);
			    	redirect_to($link);
				}
				break;
			} else {
				$link = 'signup.php?error=4&username='.$_POST['username'] . '&firstname=' . $_POST['firstname'] . '&lastname=' . $_POST['lastname'];
				redirect_to($link);
				break;
			}		
    		break;
    	case "update_user":
			$user = User::find_by_id($_SESSION['user_id']);
			if($_POST['firstname'] != ''){
				$user->first_name = $_POST['firstname'];
			} else {
				$link = 'user_settings.php?error=1&firstname=' . $user->first_name . '&lastname=' . $_POST['lastname'];
				redirect_to($link);
				break;	
			}
			$user->last_name = $_POST['lastname'];
			if($_POST['password'] != ''){
				if(strlen($_POST['password']) > 3) {
					$user->password = $_POST['password'];
				} else {
					$link = 'user_settings.php?error=2&firstname=' . $_POST['firstname'] . '&lastname=' . $_POST['lastname'];
					redirect_to($link);
					break;	
				}
			}
			$user->update();
			redirect_to('user_settings.php');
		case "create_page":
			// Create Page 
			if(!$_POST['page_name']){
				$link = build_link($_GET['parent_id']) . 'create_page/?error=1';
				redirect_to($link);
			} elseif(Page::find($_POST['page_name'], $_GET['parent_id'])){
				$link = build_link($_GET['parent_id']) . 'create_page/?error=2';
				redirect_to($link);
			}
			$new_page = Page::create_page($_POST['page_name'], $_POST['page_content'], $_GET['parent_id'], 'page', 1);
			process_tags($_POST['hiddenTagList'], $new_page, 'page');
			$link = build_link($new_page);
			redirect_to($link);
			break;
		case "edit":
			// Edit page
			$page = Page::find($_GET['file'], $_GET['parent_id']);
			$page_tags = ItemTag::find($page->id, 'page');
			if($page){
				$page->name = $_POST['page_name'];
				$page->content = $_POST['page_content'];
				$page->update();
				$link = build_link($page->id);
			} else {
				$page = Page::create_page($_POST['page_name'], $_POST['page_content'], $_GET['parent_id'], 'page', 1);
				$link = build_link($page);
			}
			process_tags($_POST['hiddenTagList'], $new_page, 'page');
			redirect_to($link);
			break;
		case "delete_page":
			// Delete page
			$page = Page::find_by_id($_GET['page_id']);
			$parent = $page->parent_id;
			$page->delete();
			if($parent == 0){
				$settings = Setting::load();
				$root = Page::find($settings->initial_page, 0);
				$level = $_GET['level'];
				$level = $level - 1;
				$link = build_link($root->id);
			} else {
				$link = build_link($parent);
			}
			redirect_to($link);
			break;
		case "update_sys_info":
			$settings = Setting::load();
			if($_POST['initial_page'] != ''){
				$settings->initial_page = $_POST['initial_page'];
			} else {
				$link = 'system_settings.php?error=1';
				redirect_to($link);
				break;	
			}
			if($_POST['email'] != ''){
				if(checkEmail($_POST['email'])){
					$settings->email = $_POST['email'];
				} else {
					$link = 'system_settings.php?error=3';
					redirect_to($link);
				}
			} else {
				$link = 'system_settings.php?error=2';
				redirect_to($link);
			}
			$settings->sys_name = $_POST['sys_name'];
			$settings->theme = $_POST['theme'];
			$settings->footer_msg = $_POST['footer_msg'];
			
			$settings->update();
			redirect_to('system_settings.php?success=1');
			break;
		case "export_db":
			$mysqlDatabaseName = DB_NAME;
			$mysqlUserName = DB_USER;
			$mysqlPassword = DB_PASS;
			$mysqlHostName = DB_SERVER;
			if($_POST['name']){
				if(!preg_match('/\s/',$_POST['name']) && !strpos($_POST['name'], '/') && !strpos($_POST['name'], '.')){
				$file_name = $_POST['name'];
				} else {
					redirect_to('system_settings.php?error=46');
					break;
				}
			} else {
				$file_name = 'db_backup.sql';
			}
			$mysqlExportPath = SITE_ROOT . DS . $file_name;
			$mysqlDumpPath = '/Applications/MAMP/Library/bin/';			
			$command = $mysqlDumpPath . 'mysqldump --opt -h ' . $mysqlHostName . ' -u ' .$mysqlUserName .' -p' .$mysqlPassword .' ' .$mysqlDatabaseName .' > ' .$mysqlExportPath;	
			exec($command,$output=array(),$worked);
			switch($worked){
			    case 0:
			        header("Cache-Control: public");
					header("Content-Description: File Transfer");
					header("Content-Length: ". filesize("$mysqlExportPath").";");
					header("Content-Disposition: attachment; filename=$file_name");
					header("Content-Type: text/sql"); 
					$fp = file($mysqlExportPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
					readfile($mysqlExportPath);
					unlink($mysqlExportPath);
					redirect_to('system_settings.php?success=2');
			        break;
			    case 1:
			        //echo 'There was a warning during the export of <b>' .$mysqlDatabaseName .'</b> to <b>~/' .$mysqlExportPath .'</b>';
			        redirect_to('system_settings.php?error=47');
			        break;
			    case 2:
			        echo 'There was an error during export. Please check your values:<br/>';
			        redirect_to('system_settings.php?error=48');
			        break;
			}
			redirect_to('system_settings.php?error=49');
			break;
		case "upload":
			if($_FILES['uploadedfile']){
				$target_path = basename( $_FILES['uploadedfile']['name']);
				$extension = find_file_extension($target_path);
				if($_POST['filename'] && $_GET['subaction'] != 'edit'){
					$filecheck = File::name_check($_POST['filename']);
					if($filecheck){
						$link = 'upload.php?error=1';
						redirect_to($link);
					} else { 
						$file_name = $_POST['filename'];
						$file_path = 'uploads/' . $file_name . '.' . $extension;
					}
				} else {
					$filecheck = File::name_check($_FILES['uploadedfile']['name']);
					if($filecheck){
						$link = 'upload.php?error=2';
						redirect_to($link);
					} else { 
						$file_name = $_FILES['uploadedfile']['name'];
						$file_path = 'uploads/' . $file_name . '.' . $extension;
					}
				}				
				if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)){					
					rename($target_path, $file_path);
					switch($extension){
						case jpg:
							$file_type = 'image';
							break;
						case jpeg:
							$file_type = 'image';
							break;
						case png:
							$file_type = 'image';
							break;
						case bmp:
							$file_type = 'image';
							break;
						case gif:
							$file_type = 'image';
							break;
						case mp4:
							$file_type = 'movie';
							break;
						case mov:
							$file_type = 'movie';
							break;
					}
					$new_file = File::add_file($file_name, $file_type, $file_path);
					$master = SpecialPage::master_page('media');
					if($master) { 
						$parent = $master->function; 
					} else { 
						$parent = 0; 
					}
					$new_page = Page::create_page($file_name, '', $parent, 'media', $new_file);
					$link = build_link($new_page);
					$new_file = $new_page;
				} else {
					$name_check = Page::find($_POST['filename'], $_GET['parent_id']);
					$page = Page::find($_GET['file'], $_GET['parent_id']);
					if(!$name_check){
						$page->name = $_POST['filename'];
						$page->update();
						$media = File::find_by_id($page->object_id);
						$media->name = $_POST['filename'];
						$media->update();
					}
					$link = build_link($page->id);
					$new_file = $page->id;
					$page_tags = ItemTag::find($page->id, 'media');
				}				
				process_tags($_POST['hiddenTagList'], $new_page, 'media');
				
				
				redirect_to($link);
			} 
			break;
	}
	
	
	


?>