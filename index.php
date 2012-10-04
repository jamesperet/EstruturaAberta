<?php
	require_once("includes/initialize.php");
	require_once("includes/markdown.php");
	$settings = Setting::load();
	$link = 'themes/' . $settings->theme . '/pages/' . $_GET["route"] . '.php';
	include($link);
?>