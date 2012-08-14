<?php 
	require_once("../includes/initialize.php");

	// Create Page 
	if($_GET['action'] == 'create') {
		$new_page = Page::create_page($_POST['page_name'], $_POST['page_content']);
		$link = $_POST['page_name'] . '/';
		redirect_to($link);
		
	}
	
	// Edit Page
	if($_GET['action'] == 'edit') {
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
	}	
	
	// Delete Page
	if($_GET['action'] == 'delete') {
		$page = Page::find($_GET['file']);
		$page->delete();
		$link = $_GET['file'] . '/';
		redirect_to($link);
	}

?>