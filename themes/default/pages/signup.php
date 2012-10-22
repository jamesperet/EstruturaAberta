<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>
	    Cadastro
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <?php
	  echo '<link href="' . back_path($level) . 'themes/' . $settings->theme . '/css/bootstrap.css" rel="stylesheet">';
    ?>
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
    </style>
    <?php
      echo '<link href="' . back_path($level) . 'themes/' . $settings->theme . '/css/bootstrap-responsive.css" rel="stylesheet">';
    ?>

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
          <?php $settings = Setting::load(); echo '<a class="brand" href="' . back_path($level) . '">' . $settings->sys_name . '</a>'; ?>
          <div class="nav-collapse">
            <ul class="nav">
               <?php build_nav_menu($level, $page_slug); ?>
            </ul>
            <ul class="nav pull-right">
			  <?php
			  	build_search_box($level);	
			  				  	
			  	echo '<li class="divider-vertical"></li><li class="dropdown">';
			  	
			  	build_user_nav_menu($user, $level, $page_slug);

			  ?>
			</ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container">
		<div class="row">
		  <div class="span6 offset3">
			<form class="well form-horizontal" action="process.php?action=signup" method="post">
				<fieldset>
					<legend>Cadastro no sistema</legend>
					
					<div class="control-group <?php if($_GET['error']==1 || $_GET['error']==4 || $_GET['error']==5){ echo 'error'; } ?>">
					  <label class="control-label" for="input01">Email</label>
					  <div class="controls">
					  	<input type="text" name="username" class="input-large" placeholder="" value="<?php if($_GET['username']){ echo $_GET['username']; } ?>">
					  	<span class="help-inline"><?php if($_GET['error']==1){ echo 'forneça um email'; } if($_GET['error']==4){ echo 'Email já cadastrado'; } if($_GET['error']==5){ echo 'Email invalido'; } ?></span>
					  </div>
					</div>
					
					<div class="control-group <?php if($_GET['error']==2 || $_GET['error']==6){ echo 'error'; } if($_GET['error']==3 || $_GET['error']==4 ){ echo 'warning'; } ?>">
					  <label class="control-label" for="input01">Senha</label>
					  <div class="controls">
					  	<input type="password" name="password" class="input-large" placeholder="">
					  	<span class="help-inline"><?php if($_GET['error']==2){ echo 'escreva uma senha'; } if($_GET['error']==6){ echo 'minimo de 4 caracteres'; } ?></span>
					  </div>
					</div>
					
					<div class="control-group <?php if($_GET['error']==3){ echo 'error'; } ?>">
					  <label class="control-label" for="input01">Nome</label>
					  <div class="controls">
					  	<input type="text" name="firstname" class="input-large" placeholder="" value="<?php if($_GET['firstname']){ echo $_GET['firstname']; } ?>">
					  	<span class="help-inline"><?php if($_GET['error']==3){ echo 'escreva seu nome'; } ?></span>
					  </div>
					</div>
					
					<div class="control-group">
					  <label class="control-label" for="input01">Sobrenome</label>
					  <div class="controls">
					  	<input type="text" name="lastname" class="input-large" placeholder="" value="<?php if($_GET['lastname']){ echo $_GET['lastname']; } ?>">
					  	<span class="help-inline"></span>
					  </div>
					</div>
					
					<div class="form-actions">
			            <button type="submit" class="btn btn-primary">Cadatrar-se</button>
			        </div>
			        
				</fieldset>
			</form>
			
		  </div>
		</div>



      <hr>

      <footer>
        <p><?php echo $settings->footer_msg; ?></p>
      </footer>

    </div> <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <?php
      echo '<script src="' . back_path($level) . 'themes/' . $settings->theme . '/js/jquery.js"></script>';
      echo '<script src="' . back_path($level) . 'themes/' . $settings->theme . '/js/bootstrap-transition.js"></script>';
      echo '<script src="' . back_path($level) . 'themes/' . $settings->theme . '/js/bootstrap-alert.js"></script>';
      echo '<script src="' . back_path($level) . 'themes/' . $settings->theme . '/js/bootstrap-modal.js"></script>';
      echo '<script src="' . back_path($level) . 'themes/' . $settings->theme . '/js/bootstrap-dropdown.js"></script>';
      echo '<script src="' . back_path($level) . 'themes/' . $settings->theme . '/js/bootstrap-scrollspy.js"></script>';
      echo '<script src="' . back_path($level) . 'themes/' . $settings->theme . '/js/bootstrap-tab.js"></script>';
      echo '<script src="' . back_path($level) . 'themes/' . $settings->theme . '/js/bootstrap-tooltip.js"></script>';
      echo '<script src="' . back_path($level) . 'themes/' . $settings->theme . '/js/bootstrap-popover.js"></script>';
      echo '<script src="' . back_path($level) . 'themes/' . $settings->theme . '/js/bootstrap-button.js"></script>';
      echo '<script src="' . back_path($level) . 'themes/' . $settings->theme . '/js/bootstrap-collapse.js"></script>';
      echo '<script src="' . back_path($level) . 'themes/' . $settings->theme . '/js/bootstrap-carousel.js"></script>';
      echo '<script src="' . back_path($level) . 'themes/' . $settings->theme . '/js/bootstrap-typeahead.js"></script>';
      echo '<script src="' . back_path($level) . 'themes/' . $settings->theme . '/js/google-code-prettify/prettify.js"></script>';
      echo '<script src="' . back_path($level) . 'themes/' . $settings->theme . '/js/bootstrap-tagmanager.js"></script>';
    ?>

  </body>
</html>
