<?php
	$user = User::find_by_id($_SESSION['user_id']);
	$settings = Setting::load();
	echo '<html>';
	echo '<h1>Bem vindo a ' . $settings->sys_name . '!</h1>';
	echo '<br>';
	echo 'Email: ' . $user->username;
	echo 'Password: ' . $user->password;
	echo '</html>';

?>