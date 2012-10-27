<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>
    	<?php 
	        if($page_slug){ 
		    	echo $page_slug;
			} else {
		    	echo SYS_NAME;
			}
    	?>
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    
    <?php
    if(!$page_slug){
      echo '<link href="' . back_path($level) . 'themes/' . $settings->theme . '/css/bootstrap.css" rel="stylesheet">';
    } else {
	  echo '<link href="' . back_path($level) . 'themes/' . $settings->theme . '/css/bootstrap.css" rel="stylesheet">';
    }
    ?>
    
    
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
    </style>
    
    <?php
    if(!$page_slug){
      echo '<link href="' . back_path($level) . 'themes/' . $settings->theme . '/css/bootstrap-responsive.css" rel="stylesheet">';
    } else {
	  echo '<link href="' . back_path($level) . 'themes/' . $settings->theme . '/css/bootstrap-responsive.css" rel="stylesheet">';
    }
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
			  if($user) {
			  	echo '<li class="dropdown"><a class="dropdown-toggle" href="#" data-toggle="dropdown"><i class="icon-plus"></i></a>';
			    echo '<ul class="dropdown-menu">';
			    echo '<li><a href="' . back_path($level) . 'create_page/">Criar página</a></li>';
			    echo '<li><a href="' . back_path($level) . 'upload/">Upload de arquivo</a></li>';
			  	echo '</ul></li>';
			  	if($page->object_id){ 
			  	    if($special_page->function == 'edit') { 
			  	    	echo '<li><a href="#edit_modal" data-toggle="modal"><i class="icon-pencil"></i></a></li>';
			  	    	echo '<li><a href="../delete/"><i class="icon-remove"></i></a></li>'; 
			  	    } 
			  	    elseif($special_page->function == 'delete') {
			  	    	echo '<li><a href="../edit/"><i class="icon-pencil"></i></a></li>'; 
			  	    	echo '<li><a href="#delete_modal" data-toggle="modal"><i class="icon-remove"></i></a></li>'; 
			  	    } else {
			  	    	echo '<li><a href="edit/"><i class="icon-pencil"></i></a></li>';
				  	    echo '<li><a href="delete/"><i class="icon-remove"></i></a></li>'; 
			  	    }
			  	}
			  	echo '<li class="divider-vertical"></li>';
			 }
			  	build_search_box($level);	
			  				    
			    echo '<li class="divider-vertical"></li><li class="dropdown">';
			    
			    build_user_nav_menu($user, $level, $page_slug);

			  ?>
			</ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container"><div class="row"><div class="span12">












  <?php
  	if($page->object_id){
  		$tag = Tag::find_by_id($page->object_id);
  		echo '<div class="page-header"><h1>' . $tag->name . ' <small>Páginas taggeadas</small></h1></div>';
  		echo '<table class="table table-bordered"><tbody><thead><tr><th>Página</th><th>Autor</th><th>data</th></tr></thead>';
  		$pages = Page::find_all();
		foreach($pages as $object) {
			$user = User::find_by_id($object->creator_id);
			if($tag){
				if(ItemTag::find_tagged_items($object->id, $tag->id)){
					echo '<tr><td><a href="'. back_path($level) . build_link($object->id) . '">' . $object->name . '</a></td><td>' . $user->full_name() .'</td><td>' . getElapsedTime($object->creation_date) .'</tr>';
				}
			} else {
				echo '<tr><td><a href="' . back_path($level) . build_link($object->id) . '">' . $object->name . '</a></td><td>' . $user->full_name() .'</td><td>' . getElapsedTime($object->creation_date) .'</tr>';
			}
		}
		echo '</tbody></table>';
  	} else {
	  	echo '<div class="page-header"><h1>Tags</h1></div>';
	  	//$all_tags = Tag::find_all();
      	$all_tags = Page::find_by_type('tag');
      	if($all_tags){
	      	foreach($all_tags as $page_tag){
	      		if($page_tag->object_id){
	      			$item_tag = Tag::find_by_id($page_tag->object_id);
	      			$tagged_items = ItemTag::count_tags($item_tag->id);
	      			echo '<a href="'. back_path($level) . build_link($page_tag->id) .'"><span class="label label-info">' . $item_tag->name . ' (' . $tagged_items . ')</span></a> ';
	      		}
	       	}
	   } else {
		   echo '<i>Nenhuma Tag no sistema...</i>';
	   }
  	}
  ?>
  
















      <hr>

      <footer>
      	<div class="row">
	      	<div class="span12">
	      	 
	      		<?php
	      			echo $settings->footer_msg;
	      		?>
	      	</div>
      	</div>
      </footer>

    </div> <!-- /container -->
    
    
    
    
    <!-- Modal -->
	<div class="modal hide" id="delete_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-header">
	    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	    <h3 id="myModalLabel">Deletar Tag</h3>
	  </div>
	  <div class="modal-body">
	    <p>Você tem certeza que quer deletar a tag <code><?php if($page) { echo $tag->name; } ?></code>?</p>
	  </div>
	  <div class="modal-footer">
	    <a class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</a>
	    <a href="<?php if($page) { echo back_path($level) . 'process.php?page_id=' . $page->id . '&level=' . $level . '&action=delete_tag'; }?>" class="btn btn-danger">Deletar</a>
	  </div>
	</div>
    
    <!-- Modal -->
	<div class="modal hide" id="edit_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <form class="form-horizontal" action="<?php echo back_path($level) . 'process.php?action=edit_tag&page_id=' . $page->id ; ?>" method="post" style="margin-bottom: 0;">	  
	  <div class="modal-header">
	    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	    <h3 id="myModalLabel">Editar Tag</h3>
	  </div>
	  <div class="modal-body">					
		<fieldset>
			<div class="control-group <?php if($_GET['error']==1 || $_GET['error']==2){ echo 'error'; } ?>">
			  <label class="control-label" for="input01">Nome da tag</label>
			  <div class="controls">
			  	<input type="text" name="tag_name" class="input-large" placeholder="" value="<?php  $tag = Tag::find_by_id($page->object_id); echo $tag->name; ?>">
			  	<span class="help-inline"><?php if($_GET['error']==1){ echo 'essa tag já existe'; } if($_GET['error']==2){ echo 'favor inserir um valor'; } ?></span>
			  </div>
			</div>
		</fieldset>
	  </div>			  
	  <div class="modal-footer">
	    <a class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</a>
	    <button type="submit" class="btn btn-primary">Salvar</button>
	  </div>
	  
	
	</form> 
	</div>    
    
    
    

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
    	   jQuery('#delete_modal').modal('<?php if($special_page->function == 'delete'){ echo 'show'; } else { echo 'hide'; } ?>');
    	   jQuery('#edit_modal').modal('<?php if($special_page->function == 'edit'){ echo 'show'; } else { echo 'hide'; } ?>');
    	  
    	});
    </script>



  </body>
</html>

    
