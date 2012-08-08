<?php 
	require_once("../includes/initialize.php");

	// Create Page
	if($_GET['file']){
		$page = Page::find($_GET['file']);
		if($page){
			$page->name = $_POST['page_name'];
			$page->content = $_POST['page_content'];
		} else {
			$page = Page::create_page($_POST['page_name'], $_POST['page_content']);
		}
		$link = $_POST['page_name'] . '/';
		redirect_to($link);
	
	}

?>