<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Editar Página</title>
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
				  if($user) {
				  	echo '<li class="divider-vertical"></li><li class="dropdown">';
				  	echo '</li><li class="dropdown">';
				    echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown">' . $user->full_name() . ' <b class="caret"></b></a>';
				    echo '<ul class="dropdown-menu">';
					echo '<li><a href="user_settings.php">Minhas configurações</a></li>';
					if($user->user_type == 'admin'){ echo '<li><a href="system_settings.php">Configurações do sistema</a></li>'; }
				    echo '<li><a href="process.php?file=' . $_GET['file'] . '&action=logout">Sair</a></li>';
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
    
    <?php $edit_action = back_path($level) . 'process.php?'; 
    	  if($special_page->function == 'edit') { 
    	  	$edit_action .= 'file=' . $page->name . '&';
    	  } 
    	  $edit_action .= 'action=' . $page_slug;
    	  if($grand_parent_page){
    	  	$edit_action .= '&parent_id=' . $grand_parent_page->id;
    	  } else {
	    	  $edit_action .= '&parent_id=0';
    	  }
    ?>
    
    <div class="row">
    	<div class="span12">
			<form class="well" method="post" action="<?php echo $edit_action ?>">
				<fieldset>
					<legend>Editar página</legend>
					
					<div class="control-group">
			            <label class="control-label" for="input01">Nome da Página</label>
			            <div class="controls">
			              <input type="text" name="page_name" class="input-xlarge" id="input01" value="<?php if($special_page->function != 'create') { echo $page->name; }?>">
			            </div>
			        </div>
			        
			        <div class="control-group">
			            <label class="control-label" for="input01">Tags</label>
			            <div class="controls">
			              <input type="text" class="input-small tagManager" style="margin: 0 auto;" data-provide="typeahead"  data-items="4"> 
			            </div>
			        </div>

					
					<div class="control-group">
						<label>Conteúdo</label>
						<textarea class="" id="textarea" name="page_content" rows="12" style="width: 99%;"><?php if($special_page->function != 'create') { echo $page->content; }?></textarea>
					</div>

		
					<div class="form-actions">
		            	<button type="submit" class="btn btn-primary">Salvar</button>
		            	<a class="btn" href="../">Cancelar</a>
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

    
    <script>
    	$(document).ready(function() {
    		 jQuery(".tagManager").tagsManager( { 
    		 	
    		 	prefilled: 
    		 	[ 
    		 		<?php
						$page_tags = ItemTag::find($page->id, 'page');
						foreach($page_tags as $item_tag){
							$tag_name = Tag::find_by_id($item_tag->tag_id);
							echo '"' . $tag_name->name . '", ';
						}
						
					?>
    		 	],
    		 	preventSubmitOnEnter: true,
    		 	typeahead: true,
    		 	typeaheadSource: 
    		 	[
    		 		<?php
						$all_tags = Tag::find_all();
	              		foreach($all_tags as $item_tag){
		              		echo '"' . $item_tag->name . '", ';
		              	}
						
					?>
    		 	]
    		 } )
    	   jQuery('#myModal').modal('<?php if($special_page->function == 'delete'){ echo 'show'; } else { echo 'hide'; } ?>');
    	  
    	});
    </script>

  </body>
</html>
