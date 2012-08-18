<?php
	require_once("../includes/initialize.php");
	
	if( $session->is_logged_in() ) {
		$user = User::find_by_id($_SESSION['user_id']);
	} else {
		$link = $_GET['file'] . '/'; 
		redirect_to($link); 
	}
	
	if($_GET['file']){ 
		$page = Page::find($_GET['file']);
	}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Editar Página</title>
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
          <a class="brand" href="index.php"><?php $settings = Setting::load(); echo $settings->sys_name; ?></a>
          <div class="nav-collapse">
            <ul class="nav">
              <li class=""><a href="pages.php">Páginas</a></li>
              <li class=""><a href="users.php">Usuários</a></li>
            </ul>
            <ul class="nav pull-right">
			  <?php
			  if($user) {
			  	echo '</li><li class="dropdown">';
			    echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown">' . $user->username . ' <b class="caret"></b></a>';
			    echo '<ul class="dropdown-menu">';
			    echo '<li><a href="process.php?file=' . $_GET['file'] . '&action=logout">Logout</a></li>';
			    echo '</ul></li>';
			  } else {
			  	  echo '<li class=""><a href="signup.php">Cadastro</a></li>';
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
    	<div class="span12">
			<form class="well" method="post" action="process.php?file=<?php echo $_GET['file'] . '&action=' . $_GET['action'];?>">
				<fieldset>
					<legend>Editar página</legend>
					
					<div class="control-group">
			            <label class="control-label" for="input01">Nome da Página</label>
			            <div class="controls">
			              <input type="text" name="page_name" class="input-xlarge" id="input01" value="<?php echo $_GET['file'];?>">
			            </div>
			        </div>

					
					<div class="control-group">
						<label>Conteúdo</label>
						<textarea class="" id="textarea" name="page_content" rows="12" style="width: 99%;"><?php echo $page->content;?></textarea>
					</div>

		
					<div class="form-actions">
		            	<button type="submit" class="btn btn-primary">Salvar</button>
		            	<button class="btn">Cancelar</button>
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
