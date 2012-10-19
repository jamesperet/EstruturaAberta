<?php

// Define software version
defined('CURRENT_VERSION') ? null : define("CURRENT_VERSION", "v0.1");

// Define the core paths
// Define them as absolute paths to make sure that require_once works as expected

// DIRECTORY_SEPARATOR is a PHP pre-defined constant
// (\ for Windows, / for Unix)
defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);

defined('SITE_ROOT') ? null : define('SITE_ROOT', getcwd());
defined('LIB_PATH') ? null : define('LIB_PATH', SITE_ROOT.DS.'includes');


$config = LIB_PATH.DS.'config.php';
$config_handle = fopen($config, 'r'); 
if(!$config_handle){
	if($_GET['file']){
		header("Location: ../install.php");
	} else {
		header("Location: install.php");
	}
} else {
	// load config file first
	
	require_once(LIB_PATH.DS.'config.php');
	
	// load basic functions next so that everything after can use them
	require_once(LIB_PATH.DS.'functions.php');
	

	
	// load core objects
	require_once(LIB_PATH.DS.'session.php');
	require_once(LIB_PATH.DS.'database.php');
	require_once(LIB_PATH.DS.'database_object.php');
	require_once(LIB_PATH.DS.'setting.php');
	require_once(LIB_PATH.DS.'user.php');
	require_once(LIB_PATH.DS.'content_type.php');
	
	// load database-related classes	
	require_once(LIB_PATH.DS.'page.php');
	require_once(LIB_PATH.DS.'file.php');
	require_once(LIB_PATH.DS.'permission.php');
	require_once(LIB_PATH.DS.'tag.php');
	require_once(LIB_PATH.DS.'ItemTag.php');
}
?>