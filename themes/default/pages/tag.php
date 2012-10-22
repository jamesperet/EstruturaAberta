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
				    echo '<li><a href="' . back_path($level) . 'upload/">Upload de arquivo</a></li>';
			  	echo '</ul></li>';
			  	//echo '<li><a href="' . back_path($level) . 'edit_page.php?file=' . $page_slug . '&action=edit""><i class="icon-pencil"></i></a></li>';
			  	//echo '<li><a href="' . back_path($level) . 'process.php?file=' . $page_slug . '&action=delete"><i class="icon-remove"></i></a></li>';
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
  	if($page->object_id){
  		$tag = Tag::find_by_id($page->object_id);
  		echo '<div class="page-header"><h1>' . $tag->name . ' <small>Páginas taggeadas</small></h1></div>';
  		echo '<table class="table table-bordered"><tbody><thead><tr><th>Página</th><th>Autor</th><th>data</th></tr></thead>';
  		$pages = Page::find_all();
		foreach($pages as $page) {
			$user = User::find_by_id($page->creator_id);
			if($tag){
				if(ItemTag::find_tagged_items($page->id, $tag->id)){
					echo '<tr><td><a href="'. back_path($level) . build_link($page->id) . '">' . $page->name . '</a></td><td>' . $user->full_name() .'</td><td>' . getElapsedTime($page->creation_date) .'</tr>';
				}
			} else {
				echo '<tr><td><a href="' . back_path($level) . build_link($page->id) . '">' . $page->name . '</a></td><td>' . $user->full_name() .'</td><td>' . getElapsedTime($page->creation_date) .'</tr>';
			}
		}
		echo '</tbody></table>';
  	} else {
	  	echo '<div class="page-header"><h1>Tags</h1></div>';
	  	//$all_tags = Tag::find_all();
      	$all_tags = Page::find_by_type('tag');
      	foreach($all_tags as $page_tag){
      		if($page_tag->object_id){
      			$item_tag = Tag::find_by_id($page_tag->object_id);
      			$tagged_items = ItemTag::count_tags($item_tag->id);
      			echo '<a href="'. back_path($level) . build_link($page_tag->id) .'"><span class="label label-info">' . $item_tag->name . ' (' . $tagged_items . ')</span></a> ';
      		}
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

    
