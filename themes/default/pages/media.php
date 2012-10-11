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
	    Media
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
		
			
	<?php
		
		if($_GET['file']){
			$file = File::find_by_id($_GET['file']);
			echo '<div class="row"><div class="span12">';
			switch($file->file_type){
				case 'image':
					echo '<h1>' . $file->name . '</h1>';
					echo '<img class="img-polaroid" src="' . $file->file_path . '">';
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
		  	echo '</div></div><div class="row">';
			$all_media = File::find_all();
			foreach($all_media as $media) {
				echo '<div class="span2" style="text-align: center;">';
				$user = User::find_by_id($media->owner_id);
				switch($media->file_type){
					case 'image':
						echo '<div class="img-polaroid" style="width: 100%; max-width: 180px;><a href="media.php?file=' . $media->id . '"><img src="' . $media->file_path . '" style="height: 130px; margin: auto;"></a></div>';
						break;
					case 'movie':
						echo '<a href="media.php?file='. $media->id .'"><div class="img-polaroid" style="width: 100%; max-width: 180px; height: 130px;"><div style="background-color: black; border-radius: 50px; width: 21px; height: 21px; margin: auto; margin-top: 55px; margin-bottom: 15px;"><i class="icon-play icon-white"></i></div></div></a>';
				}
				echo '<a href="media.php?file='. $media->id .'"><small>' . $media->name . '</small></a>';
				echo '</div>';
			}
			echo '</div>';
		}
		
	?>
				    

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
