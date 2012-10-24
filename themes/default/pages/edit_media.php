<?php
	if($page->object_id){
		$file = File::find_by_id($page->object_id);
	}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Upload de arquivo</title>
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

    <?php $edit_action = back_path($level) . 'process.php?'; 
    	  if($special_page->function == 'edit') { 
    	  	$edit_action .= 'file=' . $page->name . '&';
    	  } 
    	  $edit_action .= 'action=upload';
    	  $edit_action .= '&subaction=' . $special_page->function;
    	  if($grand_parent_page){
    	  	$edit_action .= '&parent_id=' . $grand_parent_page->id;
    	  }
    ?>

    <div class="row">
    	<div class="span12">
			<form class="well" method="post" action="<?php echo $edit_action; ?>" enctype="multipart/form-data">
				<fieldset>
					<legend>Upload de arquivo</legend>
					<?php if($_GET['error']){ echo '<div class="alert alert-error">Erro! Um arquivo já existe com esse nome.</div>';}?>
					<div class="row">
					<div class="control-group span3">
			            <label class="control-label" for="input01">Escolha um arquivo</label>
			            <div class="controls">
			              <input style="margin-bottom: 15px;" name="uploadedfile" type="file"/>
			            </div>
			        </div>
			        
			        <div class="control-group span4">
			            <label class="control-label" for="input01">Novo nome do arquivo</label>
			            <div class="controls">
			              <input type="text" name="filename" class="input-large" value="<?php echo $file->name; ?>"> 
			            </div>
			        </div>
			        
			        <div class="control-group span4">
			            <label class="control-label" for="input01">Tags</label>
			            <div class="controls">
			              <input type="text" class="input-small tagManager" style="margin: 0 auto;" data-provide="typeahead"  data-items="4"> 
			            </div>
			        </div>
					</div>
		
					<div class="form-actions">
		            	<button type="submit" class="btn btn-primary">Enviar</button>
		            	<?php if($special_page->function == 'edit'){ echo '<a class="btn" href="' . back_path($level) . build_link($parent_page->id) . '">Cancelar</a>'; } ?>
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
						$page_tags = ItemTag::find($page->id, 'media');
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
    	});
    </script>

  </body>
</html>
