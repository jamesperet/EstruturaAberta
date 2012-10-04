<?php
	require_once("includes/initialize.php");

	$mysqlDatabaseName = DB_NAME;
	$mysqlUserName = DB_USER;
	$mysqlPassword = DB_PASS;
	$mysqlHostName = DB_SERVER;
	$mysqlExportPath = SITE_ROOT . DS .'db_backup.sql';
	$mysqlDumpPath = '/Applications/MAMP/Library/bin/';
	
	$command = $mysqlDumpPath . 'mysqldump --opt -h ' . $mysqlHostName . ' -u ' .$mysqlUserName .' -p' .$mysqlPassword .' ' .$mysqlDatabaseName .' > ' .$mysqlExportPath;	
	exec($command,$output=array(),$worked);
	switch($worked){
	    case 0:
	        header("Cache-Control: public");
			header("Content-Description: File Transfer");
			header("Content-Length: ". filesize("$mysqlExportPath").";");
			header("Content-Disposition: attachment; filename=db_backup.sql");
			header("Content-Type: text/sql"); 
			$fp = file($mysqlExportPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
			readfile($mysqlExportPath);
			unlink($mysqlExportPath);
	        break;
	    case 1:
	        echo 'There was a warning during the export of <b>' .$mysqlDatabaseName .'</b> to <b>~/' .$mysqlExportPath .'</b>';
	        break;
	    case 2:
	        echo 'There was an error during export. Please check your values:<br/>';
	        break;
	}
?>  