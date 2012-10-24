<?php
	require_once("includes/initialize.php");
	require_once("includes/markdown.php");
	
	$settings = Setting::load();
		
	if( $session->is_logged_in() ) { $user = User::find_by_id($_SESSION['user_id']); }
	
	// Achar a p�gina atual procurando pela hierarquia de p�ginas na URL que vem via GET
	// Essa nova URL com variaveis s�o direcioadas pelo arquivo .htaccess
	
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
		$content_type = SpecialPage::content_type($page->page_type);
		if($page->page_type != 'page' && $page->page_type != 'tag' && $page->page_type != 'media' && $page->page_type != 'sys'){		
			$link = SITE_ROOT.DS. 'plugins' . DS . $content_type->plugin . DS . 'includes' . DS . 'ini.php';
			require_once($link);
		}
		elseif($page->page_type == 'sys'){
			$special_page = SpecialPage::find_by_id($page->object_id);
			
		}
	} else {
		$special_page = SpecialPage::find_page_by_type($page_slug, $parent_page->page_type);
		if(!$special_page){
			$special_page = SpecialPage::find_page($page_slug);
		}	
		//echo $special_page->name;
		//redirect_to($link);
	}


   
    // Mostrar o conte�do da p�gina
    if(!$page_slug){
      // Se n�o for especificada uma p�gina, carregue as informa��es do sistema
      echo '<div class="hero-unit">';
      echo '<h1>' . SYS_NAME . " " . CURRENT_VERSION .'</h1>';
      echo '<p>Software Wiki moderno escrito em PHP e que utiliza o Twitter Bootstrap e a Monzey Framework. Por James Peret.</p>';
      echo '</div>';
    } else {
	  // Se uma p�gina foi especificada
      //$page = Page::find($page_slug);
      if($page && !$special_page) {
      	if($page->page_type != 'page' && $page->page_type != 'tag' && $page->page_type != 'media'){
	      	$link = SITE_ROOT.DS. 'plugins' . DS . $content_type->plugin . DS . 'pages' . DS . $content_type->file_name;
	      	require_once($link);
      	} else {
	      	$link = SITE_ROOT.DS. 'themes' . DS . $settings->theme . DS . 'pages' . DS . $content_type->file_name;
	      	require_once($link);
	    }
	  } else {
	  	if($special_page){
	  		$link = SITE_ROOT.DS. 'themes' . DS . $settings->theme . DS . 'pages' . DS . $special_page->file_name;
	  		//echo $link;
	  		$page = $parent_page;
		  	require_once($link);
	  	} else {
	  	  // Mostrar p�gina inexistente
		  echo '<div class="hero-unit">';
	      echo '<h1>' . $page_slug .'</h1>';
	      echo '<p>Est� pagina n�o existe.</p>';
	      echo '<p><a class="btn btn-primary btn-large" href="' . back_path($level) . 'edit_page.php?file=' . $page_slug .'&action=create">Criar Pagina</a></p>';
	      echo '</div>';
	    }
	  }
    }
    

?>
