<?php
		
	if( $session->is_logged_in() ) { $user = User::find_by_id($_SESSION['user_id']); }
	
	// Achar a página atual procurando pela hierarquia de páginas na URL que vem via GET
	// Essa nova URL com variaveis são direcioadas pelo arquivo .htaccess
	
    if(!$_GET['file']){ 
		$link = $settings->initial_page . '/';
		redirect_to($link);
	}
	elseif($_GET['file'] && $_GET['file1'] && $_GET['file2'] && $_GET['file3']){
		$page_slug =  $_GET['file3'];
		$great_grand_parent_page = Page::find($_GET['file']);
		$grand_parent_page = Page::find($_GET['file1'], $great_grand_parent_page->id);
		$parent_page = Page::find($_GET['file2'], $grand_parent_page->id);
		$page = Page::find($page_slug, $parent_page->id);
		$level = 4;
	} 
	elseif($_GET['file'] && $_GET['file1']&& $_GET['file2']){
		$page_slug =  $_GET['file2'];
		$grand_parent_page = Page::find($_GET['file']);
		$parent_page = Page::find($_GET['file1'], $grand_parent_page->id);
		$page = Page::find($page_slug, $parent_page->id);
		$level = 3;	
	}
	elseif($_GET['file'] && $_GET['file1']){
		$page_slug =  $_GET['file1'];
		$parent_page = Page::find($_GET['file']);
		$page = Page::find($page_slug, $parent_page->id);
		$level = 2;
	}
	elseif($_GET['file']) {
		$page_slug =  $_GET['file'];
		$page = Page::find($page_slug);
		$level = 1;
	}
	else {
    	$level = 0;
	}
	if($page){
		$content_type = ContentType::load($page->page_type);
		if($page->page_type != 'page' && $page->page_type != 'tag' && $page->page_type != 'media'){		
			$link = SITE_ROOT.DS. 'plugins' . DS . $content_type->plugin . DS . 'includes' . DS . 'ini.php';
			require_once($link);
		}
	}

?>

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
              <li class=""><a href="<?php echo back_path($level); ?>pages.php">Páginas</a></li>
              <li><a href="<?php echo back_path($level); ?>tags.php">Tags</a></li>
              <li><a href="<?php echo back_path($level); ?>media.php">Media</a></li>
              <li class=""><a href="<?php echo back_path($level); ?>users.php">Usuários</a></li>
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
    // Mostrar o conteúdo da página
    if(!$page_slug){
      // Se não for especificada uma página, carregue as informações do sistema
      echo '<div class="hero-unit">';
      echo '<h1>' . SYS_NAME . " " . CURRENT_VERSION .'</h1>';
      echo '<p>Software Wiki moderno escrito em PHP e que utiliza o Twitter Bootstrap e a Monzey Framework. Por James Peret.</p>';
      echo '</div>';
    } else {
	  // Se uma página foi especificada
      //$page = Page::find($page_slug);
      if($page) {
      	if($page->page_type != 'page' && $page->page_type != 'tag' && $page->page_type != 'media'){
	      	$link = SITE_ROOT.DS. 'plugins' . DS . $content_type->plugin . DS . 'pages' . DS . $content_type->layout;
	      	require_once($link);
      	} else {
	      	$link = SITE_ROOT.DS. 'themes' . DS . $settings->theme . DS . 'pages' . DS . $content_type->layout;
	      	require_once($link);
	    }
	  } else {
	  	  // Mostrar página inexistente
		  echo '<div class="hero-unit">';
	      echo '<h1>' . $page_slug .'</h1>';
	      echo '<p>Está pagina não existe.</p>';
	      echo '<p><a class="btn btn-primary btn-large" href="' . back_path($level) . 'edit_page.php?file=' . $page_slug .'&action=create">Criar Pagina</a></p>';
	      echo '</div>';
	  }
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
