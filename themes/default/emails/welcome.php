<?php
	$user = User::find_by_id($_SESSION['user_id']);
	$settings = Setting::load();
	echo '<html>';
	echo '<h1>Bem vindo ' . $user->full_name() . ' a ' . $settings->sys_name . '!</h1>';
	echo '<h2>Cadastro:</h2>';
	echo 'Nome: <i>' . $user->first_name;
	echo '</i><br>';	
	echo 'Sobrenome: <i>' . $user->last_name;
	echo '</i><br>';
	echo 'Email: <i>' . $user->username;
	echo '</i><br>';
	echo 'Password: <i>' . $user->password;
	echo '</i><br></html>';

?>