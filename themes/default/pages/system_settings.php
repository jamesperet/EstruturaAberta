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
					
					<div class="control-group">
					  <label class="control-label" for="input01">Tema</label>
					  <div class="controls">
					  	<select name="theme">
					  		<?php
					  			echo '<option>' . $settings->theme . '</option>';
					  			//path to directory to scan
								$directory = "themes/";
								 
								//get all files in specified directory
								$files = glob($directory . "*");
								 
								//print each file name
								foreach($files as $file)
								{
								 $theme = explode("themes/",$file);
								 //check to see if the file is a folder/directory
								 if(is_dir($file) && $theme[1] != $settings->theme)
								 {
								  
								  
								  echo '<option>' . $theme[1] . '</option>';
								 }
								}
							?>
					  	</select>
					  </div>
					</div>
					
					<div class="control-group <?php if($_GET['error']==2 || $_GET['error']==3){ echo 'error'; } ?>">
					  <label class="control-label" for="input01">Email</label>
					  <div class="controls">
					  	<input type="text" name="email" class="input-large" placeholder="" value="<?php echo $settings->email; ?>">
					  	<span class="help-inline"><?php if($_GET['error']==2){ echo 'forneça um email'; }  if($_GET['error']==3){ echo 'Email invalido'; } ?></span>
					  </div>
					</div>
					
					<div class="control-group">
					  <label class="control-label" for="input01">Footer Copyright</label>
					  <div class="controls">
					  	<input type="text" name="footer_msg" class="input-large" placeholder="" value="<?php echo $settings->footer_msg; ?>">
					  </div>
					</div>
										
					<div class="form-actions">
			            <button type="submit" class="btn btn-primary">Salvar</button>
			        </div>
			        
				</fieldset>
			</form>
			
		  </div>
		</div>
		
		<div class="row">
			<div class="span6 offset3">
				<?php
		  		if($_GET['success'] == 2){ 
		  			echo '<div class="alert alert-success"><a class="close" data-dismiss="alert">×</a><strong>Backup do banco de dados salvo. </strong></div>';
		  		}				
			 		if($_GET['error'] == 47){ 
				  		echo '<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><strong>Erro ao exportar banco de dados. Favor checar configurações.</strong></div>';
				  	}
				?>
				<form class="well form-horizontal" action="process.php?action=export_db" method="post">
					<fieldset>
						<legend>Backup do Banco de dados</legend>
						<div class="control-group <?php if($_GET['error']==46){ echo 'error';} ?>">
						  <label class="control-label" for="input01">Nome do backup</label>
						  <div class="controls">
						  	<input type="text" name="name" class="input-large" placeholder="" value="">
						  	<span class="help-block"><?php if($_GET['error']==46){ echo 'Nome de arquivo invalido. Favor não utilizar espaços, pontos ou barras.'; } ?></span>
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
