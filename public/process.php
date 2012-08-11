<?php 
	require_once("../includes/initialize.php");

	// Create Page
	
		$page = Page::find($_GET['file']);
		if($page){
			$page->name = $_POST['page_name'];
			$page->content = $_POST['page_content'];
			$page->update();
		} else {
			$page = Page::create_page($_POST['page_name'], $_POST['page_content']);
		}
		$link = $_POST['page_name'] . '/';
		redirect_to($link);
	
	

?>