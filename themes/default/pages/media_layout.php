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
			    echo '<li><a href="' . back_path($level) . 'edit_page.php?action=create&parent_id=' . $page->parent_id . '">Criar página</a></li>';
			    if($level < 4){
			    	echo '<li><a href="' . back_path($level) . 'edit_page.php?action=create&parent_id=' . $page->id . '">Criar sub-página</a></li>';
			    }
			    echo '<li><a href="' . back_path($level) . 'upload.php?file=' . $page_slug . '">Upload de arquivo</a></li>';
			  	echo '</ul></li>';
			  	echo '<li><a href="' . back_path($level) . 'edit_page.php?file=' . $page_slug . '&action=edit""><i class="icon-pencil"></i></a></li>';
			  	echo '<li><a href="' . back_path($level) . 'process.php?file=' . $page_slug . '&action=delete"><i class="icon-remove"></i></a></li>';
			  	echo '<li class="divider-vertical"></li>';
			 }
			  	echo '<li><form class="navbar-search pull-left method="post" action="' . back_path($level) . 'search.php"><input name="query" type="text" class="input-small search-query" placeholder="Busca"></form></li>';
			    echo '<li class="divider-vertical"></li><li class="dropdown">';
			 if($user) {
			    echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown">' . $user->full_name() . ' <b class="caret"></b></a>';
			    echo '<ul class="dropdown-menu">';
			    echo '<li><a href="' . back_path($level) . 'user_settings.php">Minhas configurações</a></li>';
			    if($user->user_type == 'admin'){ echo '<li><a href="' . back_path($level) . 'system_settings.php">Configurações do sistema</a></li>'; }
			    echo '<li><a href="' . back_path($level) . 'process.php?file=' . $page_slug . '&action=logout">Sair</a></li>';
			    echo '</ul></li>';
			  } else {
			  	  echo '<li class=""><a href="' . back_path($level) . 'signup.php">Cadastro</a></li>';
				  echo '<li class=""><a href="' . back_path($level) . 'login.php">Entrar</a></li>';
			  }

			  ?>
			</ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container">















<?php
	
	if($page->object_id){
		$file = File::find_by_id($page->object_id);
		echo '<div class="row"><div class="span12">';
		switch($file->file_type){
			case 'image':
				echo '<h1>' . $file->name . '</h1>';
				echo '<img class="img-polaroid" src="' . back_path($level) . DS . $file->file_path . '">';
				break;
			case 'movie':
				echo '<h1>' . $file->name . '</h1>';
				echo '<video controls><source src="' . $file->file_path . '" type="video/mp4"></video';
				break;
		}
		echo '</div></div>';
	} else {
		echo '<div class="row"><div class="span12">';
	  	echo '<h1>Media</h1>';
	  	echo '</div>';
		$all_media = File::find_all();
		$columns = 0;
		foreach($all_media as $media) {
			if($columns == 0){
				$columns = 6;
				echo '</div><div class="row">';
			}
			echo '<div class="span2" style="text-align: center;">';
			$user = User::find_by_id($media->owner_id);
			switch($media->file_type){
				case 'image':
					echo '<div class="img-polaroid" style="width: 100%; max-width: 180px;"><a href="media.php?file=' . $media->id . '"><img src="'  . back_path($level) . DS . $media->file_path . '" style="height: 130px; margin: auto;"></a></div>';
					break;
				case 'movie':
					echo '<a href="media.php?file='. $media->id .'"><div class="img-polaroid" style="width: 100%; max-width: 180px; height: 130px;"><div style="background-color: black; border-radius: 50px; width: 21px; height: 21px; margin: auto; margin-top: 55px; margin-bottom: 15px;"><i class="icon-play icon-white"></i></div></div></a>';
			}
			echo '<a href="media.php?file='. $media->id .'"><small>' . $media->name . '</small></a>';
			echo '</div>';
			$columns = $columns - 1;
		}
		echo '</div>';
	}
	
?>















      <hr>

      <footer>
      	<div class="row">
	      	<div class="span12">
	      	 
	      		<?php
	      			if($page){
	      				if($page->page_type != 'tag' && $page->content != 'list_pages'){
		      				echo '<p>Tags: ';
			      			$page_tags = ItemTag::find($page->id, 'page');
			      			foreach($page_tags as $item_tag){
				      			$tag_name = Tag::find_by_id($item_tag->tag_id);
				      			echo '<a href="' . back_path($level) . 'pages.php?tag=' . $tag_name->name .'"><span class="label label-info">' . $tag_name->name . "</span></a> ";
				      		}
				      		$user = User::find_by_id($page->creator_id);
				      		echo '| <i class="icon-user"></i> '. $user->full_name() .' ';
				      		echo '| <i class="icon-calendar"></i> ' . getElapsedTime($page->creation_date) . ' | ';
				      	}
			      		
		      		}
	      			echo $settings->footer_msg;
	      		?>
	      	</div>
      	</div>
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
