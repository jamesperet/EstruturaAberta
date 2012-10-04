<?php
	require_once("includes/initialize.php");
	require_once("includes/markdown.php");
	$settings = Setting::load();
	if(strpos($_GET["route"], "process.php")){
		echo 'yeah';
	}
	$link = 'themes/' . $settings->theme . '/pages/' . $_GET["route"] . '.php';
	include($link);
?>