<?php
	//require_once("includes/initialize.php");
	if( $session->is_logged_in() ) {
		$user = User::find_by_id($_SESSION['user_id']);
	}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>
	    Lista de páginas
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <?php
	  echo '<link href="themes/' . $settings->theme . '/css/bootstrap.css" rel="stylesheet">';
    ?>
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
    </style>
    <?php
      echo '<link href="themes/' . $settings->theme . '/css/bootstrap-responsive.css" rel="stylesheet">';
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
          <a class="brand" href="index.php"><?php $settings = Setting::load(); echo $settings->sys_name; ?></a>
          <div class="nav-collapse">
            <ul class="nav">
              <li class="active"><a href="pages.php">Páginas</a></li>
              <li><a href="tags.php">Tags</a></li>
              <li><a href="media.php">Media</a></li>
              <li class=""><a href="users.php">Usuários</a></li>
            </ul>
            <ul class="nav pull-right">
			  <?php
			  
			  	echo '<li><form class="navbar-search pull-left method="post" action="search.php"><input name="query" type="text" class="input-small search-query" placeholder="Busca"></form></li>';
			  	echo '<li class="divider-vertical"></li><li class="dropdown">';
			 if($user) {
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
		<div class="row">
			<div class="span12">
				<div class="page-header">
				  <?php
				  	if($_GET['tag']){
				  		echo '<h1>' . $_GET['tag'] . ' <small>Páginas taggeadas</small></h1>';
				  	} else {
					  	echo '<h1>Lista de páginas</h1>';
				  	}
				  ?>
				  
				</div>
				<table class="table table-bordered">
				  <tbody>
				    <thead>
					    <tr>
					      <th>Página</th>
					      <th>Autor</th>
					      <th>data</th>
					    </tr>
					</thead>
						<?php
							$pages = Page::find_all();
								foreach($pages as $page) {
									$user = User::find_by_id($page->creator_id);
									if($_GET['tag']){
										$tag = Tag::find($_GET['tag']);
										if(ItemTag::find_object_tag($page->id, $tag->id, 'page')){
											echo '<tr><td><a href="' . $page->name . '/">' . $page->name . '</a></td><td>' . $user->full_name() .'</td><td>' . getElapsedTime($page->creation_date) .'</tr>';
										}
									} else {
										echo '<tr><td><a href="' . $page->name . '/">' . $page->name . '</a></td><td>' . $user->full_name() .'</td><td>' . getElapsedTime($page->creation_date) .'</tr>';
									}
								}
						?>
				    
				  </tbody>
				</table>
			</div>
		</div>



      <hr>

      <footer>
        <p>&copy; High Effects 2012</p>
      </footer>

    </div> <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <?php
      echo '<script src="themes/' . $settings->theme . '/js/jquery.js"></script>';
      echo '<script src="themes/' . $settings->theme . '/js/bootstrap-transition.js"></script>';
      echo '<script src="themes/' . $settings->theme . '/js/bootstrap-alert.js"></script>';
      echo '<script src="themes/' . $settings->theme . '/js/bootstrap-modal.js"></script>';
      echo '<script src="themes/' . $settings->theme . '/js/bootstrap-dropdown.js"></script>';
      echo '<script src="themes/' . $settings->theme . '/js/bootstrap-scrollspy.js"></script>';
      echo '<script src="themes/' . $settings->theme . '/js/bootstrap-tab.js"></script>';
      echo '<script src="themes/' . $settings->theme . '/js/bootstrap-tooltip.js"></script>';
      echo '<script src="themes/' . $settings->theme . '/js/bootstrap-popover.js"></script>';
      echo '<script src="themes/' . $settings->theme . '/js/bootstrap-button.js"></script>';
      echo '<script src="themes/' . $settings->theme . '/js/bootstrap-collapse.js"></script>';
      echo '<script src="themes/' . $settings->theme . '/js/bootstrap-carousel.js"></script>';
      echo '<script src="themes/' . $settings->theme . '/js/bootstrap-typeahead.js"></script>';
      echo '<script src="themes/' . $settings->theme . '/js/google-code-prettify/prettify.js"></script>';
    ?>

  </body>
</html>
