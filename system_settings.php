<?php
	require_once("includes/initialize.php");
	
	if( !$session->is_logged_in() ) { redirect_to('login.php'); }
	$user = User::find_by_id($_SESSION['user_id']);
	if($user->user_type != 'admin') {redirect_to('error.php?error=1');}
	
	$settings = Setting::load();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>
	    Configurações do sistema
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    
    <link href="css/bootstrap.css" rel="stylesheet">
    
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
    </style>
    
    <link href="css/bootstrap-responsive.css" rel="stylesheet">

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

    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="index.php"><?php echo $settings->sys_name; ?></a>
          <div class="nav-collapse">
            <ul class="nav">
              <li class=""><a href="pages.php">Páginas</a></li>
              <li class=""><a href="users.php">Usuários</a></li>
            </ul>
            <ul class="nav pull-right">
			  <?php
				echo '<li><form class="navbar-search pull-left method="post" action="search.php"><input name="query" type="text" class="input-small search-query" placeholder="Busca"></form></li>';
			  	echo '<li class="divider-vertical"></li><li class="dropdown">';
			  if($user) {
			    echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown">' . $user->full_name() . ' <b class="caret"></b></a>';
			    echo '<ul class="dropdown-menu">';
				echo '<li><a href="user_settings.php">Minhas configurações</a></li>';
				if($user->user_type == 'admin'){ echo '<li class="active"><a href="system_settings.php">Configurações do sistema</a></li>'; }
			    echo '<li><a href="process.php?file=' . $_GET['file'] . '&action=logout">Sair</a></li>';
			    echo '</ul></li>';
			  } else {
			  	  echo '<li class="active"><a href="signup.php">Cadastro</a></li>';
				  echo '<li class=""><a href="login.php">Entrar</a></li>';
			  }

			  ?>
			</ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container">
		<div class="row">
		  <div class="span6 offset3">
		  	<?php 
		  		if($_GET['success'] == 1){ 
		  			echo '<div class="alert alert-success"><a class="close" data-dismiss="alert">×</a><strong>Configurações do sistema atualizadas. </strong></div>';
		  		}
		  	?>
			<form class="well form-horizontal" action="process.php?action=update_sys_info" method="post">
				<fieldset>
					<legend>Configurações do sistema</legend>

					
					<div class="control-group">
					  <label class="control-label" for="input01">Nome do site</label>
					  <div class="controls">
					  	<input type="text" name="sys_name" class="input-large" placeholder="" value="<?php echo $settings->sys_name; ?>">
					  	<span class="help-inline"></span>
					  </div>
					</div>
					
					<div class="control-group <?php if($_GET['error']==1){ echo 'error';} ?>">
					  <label class="control-label" for="input01">Página inicial</label>
					  <div class="controls">
					  	<input type="text" name="initial_page" class="input-large" placeholder="" value="<?php echo $settings->initial_page; ?>">
					  	<span class="help-inline"><?php if($_GET['error']==1){ echo 'Indique uma página'; } ?></span>
					  </div>
					</div>
					
					<div class="form-actions">
			            <button type="submit" class="btn btn-primary">Salvar</button>
			        </div>
			        
				</fieldset>
			</form>
			
		  </div>
		</div>



      <hr>

      <footer>
        <p>&copy; High Effects 2012</p>
      </footer>

    </div> <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap-transition.js"></script>
    <script src="js/bootstrap-alert.js"></script>
    <script src="js/bootstrap-modal.js"></script>
    <script src="js/bootstrap-dropdown.js"></script>
    <script src="js/bootstrap-scrollspy.js"></script>
    <script src="js/bootstrap-tab.js"></script>
    <script src="js/bootstrap-tooltip.js"></script>
    <script src="js/bootstrap-popover.js"></script>
    <script src="js/bootstrap-button.js"></script>
    <script src="js/bootstrap-collapse.js"></script>
    <script src="js/bootstrap-carousel.js"></script>
    <script src="js/bootstrap-typeahead.js"></script>

  </body>
</html>
