<?php
	
	if($_GET['index'] == 2){ $index = 2; }
	else if($_GET['index'] == 3){ $index = 3; }
	else if($_GET['index'] == 4){ $index = 4; }
	else if($_GET['index'] == 5){ $index = 5; }
	else if($_GET['index'] == 6){ $index = 6; }
	else { $index = 1; }

	switch($_GET['action']){
		case install:
			if($_POST['db_name']  == ""){$error = 3;}
			if($_POST['password'] == ""){$error = 2;}
			if($_POST['username'] == ""){$error = 1;} 
			if($_POST['host'] == ""){$error = 457;}
			if($_POST['username'] != "" && $_POST['password'] != "" && $_POST['db_name'] != ""){
				$connection = mysql_connect($_POST['host'], $_POST['username'], $_POST['password']);
				if (!$connection) {
					$error=4;
				} else {
					$myFile = "includes/config.php";
					$fh = fopen($myFile, 'w') or die("can't open file");
					$stringData  = "<?php\n";
					$stringData .= "   defined('SYS_NAME') ? null : define(\"SYS_NAME\", \"Estrutura Aberta\");\n";
					$stringData .= "   defined('DB_SERVER') ? null : define(\"DB_SERVER\", \"localhost\");\n";
					$stringData .= "   defined('DB_USER') ? null : define(\"DB_USER\", \"" . $_POST['username'] ."\");\n";
					$stringData .= "   defined('DB_PASS') ? null : define(\"DB_PASS\", \"" . $_POST['password'] ."\");\n";
					$stringData .= "   defined('DB_NAME') ? null : define(\"DB_NAME\", \"" . $_POST['db_name'] ."\");\n";
					$stringData .= "?>";
					fwrite($fh, $stringData);
					fclose($fh);
					$index = 3;
				}
			}
			break;
		case db_install:
			require_once("includes/config.php");
			$connection = mysql_connect(DB_SERVER, DB_USER, DB_PASS);
			
			$sql = "CREATE DATABASE `" . DB_NAME . "`;";
			mysql_query($sql, $connection);
		
			$db_select = mysql_select_db(DB_NAME, $connection);
													
			//$sql = implode ('', file ('includes/db.sql'));
			
			$fp = file('includes/db.sql', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
			$query = '';
			foreach ($fp as $line) {
			    if ($line != '' && strpos($line, '--') === false) {
			        $query .= $line;
			        if (substr($query, -1) == ';') {
			            mysql_query($query, $connection);
			            $query = '';
			        }
			    }
			}
			
			//mysql_query($sql, $connection);
			mysql_close($connection);
			
			require_once("includes/initialize.php");
			Setting::install('Estrutura Aberta', 'home');
			$index = 4;				
			break;
		case sys_settings:
			if($_POST['initial_page'] == ""){$error = 5;}
			if($_POST['sys_name']  == ""){$error = 4;}
			if($_POST['sys_name'] != "" && $_POST['initial_page']){
				require_once("includes/initialize.php");
				$settings = Setting::load();
				$settings->sys_name = $_POST['sys_name'];
				$settings->initial_page = $_POST['initial_page'];
				$settings->theme = 'default';
				$settings->update();
				$index = 5;
			}
			break;
		case "signup":
			require_once("includes/initialize.php");
			// Test for blank inputs		
			if($_POST['username'] == '') { 
				$error = 6;
				break;
			}
			if(!checkEmail($_POST['username'])) { 
				$error = 7;
				break;
			}
			if($_POST['password'] == '') { 
				$error = 8;
				break;
			}
			if(strlen($_POST['password']) < 4) {
				$error = 9;
				break;
			}
			if($_POST['firstname'] == '') { 
				$error = 10;
				break;
			}	
			User::addUser($_POST['username'], $_POST['password'], '', $_POST['firstname'], $_POST['lastname']);
			$new_user = User::authenticate($_POST['username'], $_POST['password']);
			if ($new_user) {
			    $session->login($new_user);
			    $user = User::find_by_id($_SESSION['user_id']);
			    $user->user_type = 'admin';
			    $user->update();
			    $index = 6;
			    break;
			} else {
				$error = 11;
				break;
			}		
    		break;
	}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>
	    Instalação
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    
    <link href="themes/default/css/bootstrap.css" rel="stylesheet">
    
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
    </style>
    
    <link href="themes/default/css/bootstrap-responsive.css" rel="stylesheet">

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="images/favicon.ico">
    <link rel="apple-touch-icon" href="images/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="images/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="images/apple-touch-icon-114x114.png">
  </head>

  <body>

    <div class="container">
		<div class="row">
		  <div class="span6 offset3 well">
		  	
		  	<?php 
		  		switch($index) {
		  		// Introdução
		  		case 1:
		  			echo '<div class="page-header"><h1>Instalação<small class="pull-right"style="margin-top:10px;">1/5</small></h1></div>';
					echo '	<div class="progress progress-success progress-striped">';
					echo '	  <div class="bar" style="width: 0%"></div>';
					echo '    </div>';

					echo '		<p class="lead">Bem vindo ao <a href="http://github/jamesperet/EstruturaAberta">Estrutura Aberta</a> versão 0.2, criado por <a href="http://www.jamesperet.com">James Peret</a>. Nos proximos passos você será guiado pela instalação do software.';

					echo '	<div class="modal-footer">';
					echo '		<a class="btn" href="install.php?index=2">Proximo passo</a>';
					echo '	</div>';
					break;
				// Credencias do Banco de dados
				case 2:
		  			echo '<div class="page-header"><h1>Instalação<small class="pull-right"style="margin-top:10px;">2/5</small></h1></div>';
					echo '<form class="form-horizontal" action="install.php?action=install&index=2" method="post">';
					echo '	<div class="progress progress-success progress-striped">';
					echo '	  <div class="bar" style="width: 10%"></div>';
					echo '    </div>';
					echo '	<fieldset>';
					echo '		<legend>Banco de dados MySQL</legend>';
					if($status == 1){ echo '<div class="alert alert-success">Banco de dados conectado.</div>'; }
					if($error == 4){ echo '<div class="alert alert-error">'. mysql_error() .'</div>'; }
					if($error == 5){ echo '<div class="alert alert-error">Banco de dados já existe.</div>'; }	
					echo '		<div class="control-group '; if($error==457){ echo 'error'; } echo '">';
					echo '		  <label class="control-label" for="input01">Host</label>';
					echo '		  <div class="controls">';
					echo '		  	<input type="text" name="host" class="input-large" placeholder="" value="'; if($_POST['db_name']){ echo $_POST['db_name']; } echo '">';
					if($error==457){ echo '<span class="help-block">Informe o caminho para o servidor MySQL (ex: localhost)'; } echo '</span>';
					echo '		  </div>';
					echo '		</div>';
	
					echo '		<div class="control-group '; if($error==1 || $error==4){ echo 'error'; } echo '">';
					echo '		  <label class="control-label" for="input01">Usuário</label>';
					echo '		  <div class="controls">';
					echo '		  	<input type="text" name="username" class="input-large" placeholder="" value="'; if($_POST['username']){ echo $_POST['username']; } echo '">';
					if($error==1){echo '<span class="help-block"> forneça o nome de usuário do banco de dados do seu servidor</span>'; }
					echo '		  </div>';
					echo '		</div>';
					echo '		<div class="control-group '; if($error==2){ echo 'warning'; } if($error==4){ echo 'error'; } echo '">';
					echo '		  <label class="control-label" for="input01">Senha</label>';
					echo '		  <div class="controls">';
					echo '		  	<input type="password" name="password" class="input-large" placeholder="" >';
					echo '		  	<span class="help-inline">'; if($error==2){ echo 'digite a senha'; } echo '</span>';
					echo '		  </div>';
					echo '		</div>';
					echo '		<div class="control-group '; if($error==3){ echo 'error'; } echo '">';
					echo '		  <label class="control-label" for="input01">Banco de dados</label>';
					echo '		  <div class="controls">';
					echo '		  	<input type="text" name="db_name" class="input-large" placeholder="" value="'; if($_POST['db_name']){ echo $_POST['db_name']; } echo '">';
					echo '		  	<span class="help-block">'; if($error==3){ echo 'Escreva o nome para o banco de dados'; } echo '</span>';
					echo '		  </div>';
					echo '		</div>';
					echo '	</fieldset>';
					echo '	<div class="modal-footer">';
					echo '		<a class="btn" href="install.php?index=1">Voltar</a>';
					echo '		<button type="submit" class="btn btn-success">Proximo</button>';
					echo '	</div>';
					echo '</form>';
					break;
		  		// Instalação do Banco de dados
		  		case 3:
		  			echo '<div class="page-header"><h1>Instalação<small class="pull-right"style="margin-top:10px;">2/5</small></h1></div>';
					echo '<form class="form-horizontal" action="install.php?action=db_install&index=4" method="post">';
					echo '	<div class="progress progress-success progress-striped">';
					echo '	  <div class="bar" style="width: 25%"></div>';
					echo '    </div>';
					echo '	<fieldset>';
					echo '		<legend>Seleção do Banco de dados MySQL</legend>';
					require_once("includes/config.php");
					$connection = mysql_connect(DB_SERVER, DB_USER, DB_PASS);
					$db_select = mysql_select_db(DB_NAME, $connection);
					mysql_close($connection);
					if ($db_select) {
						echo '<p>O banco de dados <i>'. DB_NAME . '</i> já existe.<br> Você tem certeza que quer usa-lo?</p>';
						echo '	<div class="modal-footer">';
						echo '		<a class="btn" href="install.php?index=2">Não</a>';
						echo '		<a class="btn btn-success" href="install.php?index=6">Sim</a>';
						echo '	</div>';
					} else {
						echo '<p>Criar um novo banco de dados com o nome <i>'. DB_NAME . '</i>?</p>';
						echo '	<div class="modal-footer">';
						echo '		<a class="btn" href="install.php?index=2">Não</a>';
						echo '		<button class="btn btn-success">Sim</button>';
						echo '	</div>';						
					}

					break;
				// Configurações do sistema
				case 4:
		  			echo '<div class="page-header"><h1>Instalação<small class="pull-right"style="margin-top:10px;">3/5</small></h1></div>';
					echo '<form class="form-horizontal" action="install.php?action=sys_settings&index=3" method="post">';
					echo '	<div class="progress progress-success progress-striped">';
					echo '	  <div class="bar" style="width: 50%"></div>';
					echo '    </div>';
					echo '	<fieldset>';
					echo '		<legend>Informações do site</legend>';	
					echo '		<div class="control-group '; if($error==4){ echo 'error'; } echo '">';
					echo '		  <label class="control-label" for="input01">Nome do site</label>';
					echo '		  <div class="controls">';
					echo '		  	<input type="text" name="sys_name" class="input-large" placeholder="" value="'; if($_POST['sys_name']){ echo $_POST['sys_name']; } echo '">';
					if($error==4){echo '<span class="help-inline">forneça um nome</span>'; }
					echo '		  </div>';
					echo '		</div>';
					echo '		<div class="control-group '; if($error==5){ echo 'error'; } echo '">';
					echo '		  <label class="control-label" for="input01">Página inicial</label>';
					echo '		  <div class="controls">';
					echo '		  	<input type="text" name="initial_page" class="input-large" placeholder="ex: home" value="'; if($_POST['initial_page']){ echo $_POST['initial_page']; } echo '">';
					echo '		  	<span class="help-inline">'; if($error==5){ echo 'forneça um nome'; } echo '</span>';
					echo '		  </div>';
					echo '		</div>';
					echo '	</fieldset>';
					echo '	<div class="modal-footer">';
					echo '		<button type="submit" class="btn">Proximo passo</button>';
					echo '	</div>';
					echo '</form>';
					break;
				// Cadastro do administrador
				case 5:
		  			echo '<div class="page-header"><h1>Instalação<small class="pull-right"style="margin-top:10px;">4/5</small></h1></div>';
					echo '<form class="form-horizontal" action="install.php?action=signup&index=4" method="post">';
					echo '	<div class="progress progress-success progress-striped">';
					echo '	  <div class="bar" style="width: 75%"></div>';
					echo '    </div>';
					echo '	<fieldset>';
					echo '		<legend>Cadastro do administrador</legend>';	
					if($error == 11){ echo '<div class="alert alert-error">Erro ao iniciar sessão do novo usuário</div>'; }	
					echo '		<div class="control-group '; if($error==6 || $error==7){ echo 'error'; } echo '">';
					echo '		  <label class="control-label" for="input01">Email</label>';
					echo '		  <div class="controls">';
					echo '		  	<input type="text" name="username" class="input-large" placeholder="" value="'; if($_POST['username']){ echo $_POST['username']; } echo '">';
					if($error==6){echo '<span class="help-inline">forneça seu email</span>'; }
					if($error==7){echo '<span class="help-inline">email invalido</span>'; }
					echo '		  </div>';
					echo '		</div>';
					echo '		<div class="control-group '; if($error==8){ echo 'warning'; } if($error==9){ echo 'error'; } echo '">';
					echo '		  <label class="control-label" for="input01">Senha</label>';
					echo '		  <div class="controls">';
					echo '		  	<input type="password" name="password" class="input-large" placeholder="" value="">';
					echo '		  	<span class="help-inline">'; if($error==8){ echo 'forneça uma senha'; } if($error==9){ echo 'minimo de 4 caracteres'; } echo '</span>';
					echo '		  </div>';
					echo '		</div>';
					echo '		<div class="control-group '; if($error==10){ echo 'error'; } echo '">';
					echo '		  <label class="control-label" for="input01">Nome</label>';
					echo '		  <div class="controls">';
					echo '		  	<input type="text" name="firstname" class="input-large" placeholder="" value="'; if($_POST['firstname']){ echo $_POST['firstname']; } echo '">';
					echo '		  	<span class="help-inline">'; if($error==10){ echo 'forneça seu nome'; } echo '</span>';
					echo '		  </div>';
					echo '		</div>';
					echo '		<div class="control-group">';
					echo '		  <label class="control-label" for="input01">Nome</label>';
					echo '		  <div class="controls">';
					echo '		  	<input type="text" name="lastname" class="input-large" placeholder="" value="'; if($_POST['lastname']){ echo $_POST['lastname']; } echo '">';
					echo '		  </div>';
					echo '		</div>';
					echo '	</fieldset>';
					echo '	<div class="modal-footer">';
					echo '		<button type="submit" class="btn">Cadastrar-se</button>';
					echo '	</div>';
					echo '</form>';
					break;
				// Fim da instalação
				case 6:
		  			echo '<div class="page-header"><h1>Instalação<small class="pull-right"style="margin-top:10px;">5/5</small></h1></div>';
					echo '	<div class="progress progress-success progress-striped">';
					echo '	  <div class="bar" style="width: 100%"></div>';
					echo '    </div>';

					//echo '		<legend>Configurações</legend>';
					echo '		<p class="lead">O software foi instalado e suas configurações foram salvas.';

					echo '	<div class="modal-footer">';
					echo '		<a class="btn btn-success" href="index.php">Iniciar Sistema</a>';
					echo '	</div>';
					break;
				}
				
			?>
			</div>
		</div>

    </div> <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="../assets/js/jquery.js"></script>
    <script src="../assets/js/bootstrap-transition.js"></script>
    <script src="../assets/js/bootstrap-alert.js"></script>
    <script src="../assets/js/bootstrap-modal.js"></script>
    <script src="../assets/js/bootstrap-dropdown.js"></script>
    <script src="../assets/js/bootstrap-scrollspy.js"></script>
    <script src="../assets/js/bootstrap-tab.js"></script>
    <script src="../assets/js/bootstrap-tooltip.js"></script>
    <script src="../assets/js/bootstrap-popover.js"></script>
    <script src="../assets/js/bootstrap-button.js"></script>
    <script src="../assets/js/bootstrap-collapse.js"></script>
    <script src="../assets/js/bootstrap-carousel.js"></script>
    <script src="../assets/js/bootstrap-typeahead.js"></script>

  </body>
</html>
