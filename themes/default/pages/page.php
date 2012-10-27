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
				    echo '<li><a href="../create_page/">Criar página</a></li>';
				    if($level < 4){
				    	echo '<li><a href="create_page/">Criar sub-página</a></li>';
				    }
				    echo '<li><a href="' . back_path($level) . 'upload/">Upload de arquivo</a></li>';
				  	echo '</ul></li>';
				  	if($page->page_type == 'page' && $page->content != 'list_pages'){
				  		echo '<li><a href="edit/"><i class="icon-pencil"></i></a></li>';
				  		echo '<li><a href="delete/"><i class="icon-remove"></i></a></li>';
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

    <div class="container">











<?php
	if($page->object_id != 0){
  	  // Carregar a página do banco de dados
      echo '<div class="row"><div class="span12">';
      echo markdown($page->content);
      echo '</div></div>';
    } else { 			
		echo '<div class="page-header"><h1>Lista de páginas</h1></div>';
		echo '<table class="table table-bordered"><tbody><thead><tr><th>Página</th><th>Autor</th><th>data</th></tr></thead>';				
		$pages = Page::find_by_type('page');
			foreach($pages as $page) {
				$user = User::find_by_id($page->creator_id);
				if($_GET['tag']){
					$tag = Tag::find($_GET['tag']);
					if(ItemTag::find_object_tag($page->id, $tag->id, 'page')){
						echo '<tr><td><a href="' . back_path($level) . build_link($page->id) . '">' . $page->name . '</a></td><td>' . $user->full_name() .'</td><td>' . getElapsedTime($page->creation_date) .'</tr>';
					}
				} else {
					echo '<tr><td><a href="' . back_path($level) . build_link($page->id) . '">' . $page->name . '</a></td><td>' . $user->full_name() .'</td><td>' . getElapsedTime($page->creation_date) .'</tr>';
				}
			}
		echo '</tbody></table>';
	}
?>











      <hr>

      <footer>
      	<div class="row">
	      	<div class="span12">
	      	 
	      		<?php
	      			if($page){
	      				if($page->page_type != 'tag' && !$all_media && $page->content != 'list_pages'){
			      			$page_tags = ItemTag::find($page->id, 'page');
			      			if($page_tags){
				      			echo '<p>Tags: ';
				      			foreach($page_tags as $item_tag){
					      			$tag_name = Tag::find_by_id($item_tag->tag_id);
					      			$tag_page = Page::find_by_object_id($tag_name->id, 'tag');
					      			echo '<a href="' . back_path($level) . build_link($tag_page->id) .'"><span class="label label-info">' . $tag_name->name . "</span></a> ";
					      		}
					      		echo '| ';
				      		}
				      		$user = User::find_by_id($page->creator_id);
				      		echo '<i class="icon-user"></i> '. $user->full_name() .' ';
				      		echo '| <i class="icon-calendar"></i> ' . getElapsedTime($page->creation_date) . ' | ';
				      	}
			      		
		      		}
	      			echo $settings->footer_msg;
	      		?>
	      	</div>
      	</div>
      </footer>

    </div> <!-- /container -->
    
    
    <!-- Modal -->
	<div class="modal hide" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-header">
	    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	    <h3 id="myModalLabel">Deletar Página</h3>
	  </div>
	  <div class="modal-body">
	    <p>Você tem certeza que quer deletar a página <code>/<?php if($page) { echo build_link($page->id); } ?></code>?</p>
	  </div>
	  <div class="modal-footer">
	    <a class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</a>
	    <a href="<?php if($page) { echo back_path($level) . 'process.php?page_id=' . $page->id . '&level=' . $level . '&action=delete_page'; }?>" class="btn btn-danger">Deletar</a>
	  </div>
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
    	   jQuery('#myModal').modal('<?php if($special_page->function == 'delete'){ echo 'show'; } else { echo 'hide'; } ?>');
    	  
    	});
    </script>


  </body>
</html>

