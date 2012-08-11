<?php
	require_once("../includes/initialize.php");
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>
    	<?php 
	    	if($_GET['file']){ 
	    		echo $_GET['file'];
	    		$root = 1;
	    	} else {
		    	echo SYS_NAME;
		    	$root = 0;
	    	}
    	?>
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    
    <?php
    if(!$_GET['file']){
      echo '<link href="css/bootstrap.css" rel="stylesheet">';
    } else {
	  echo '<link href="../css/bootstrap.css" rel="stylesheet">';
    }
    ?>
    
    
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
    </style>
    
    <?php
    if(!$_GET['file']){
      echo '<link href="css/bootstrap-responsive.css" rel="stylesheet">';
    } else {
	  echo '<link href="../css/bootstrap-responsive.css" rel="stylesheet">';
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
          <a class="brand" href="index.php">Estrutura Aberta</a>
          <div class="nav-collapse">
            <ul class="nav">
              <li class="active"><a href="index.php">Home</a></li>
            </ul>
            <ul class="nav pull-right">
			  <li class=""><a href="edit_page.php"><i class="icon-plus icon-white"></i></a></li>
			  <?php
			  echo '<li><a href="../edit_page.php?file=' . $_GET['file'] . '"><i class="icon-pencil icon-white"></i></a></li>';
			  echo '<li><a href="../process.php?file=' . $_GET['file'] . '&action=delete"><i class="icon-remove icon-white"></i></a></li>';
			  ?>
			  
			</ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container">

    
    <?php    
    // Mostrar o conteúdo da página
    if(!$_GET['file']){
      // Se não for especificada uma página, carregue as informações do sistema
      echo '<div class="hero-unit">';
      echo '<h1>' . SYS_NAME . " " . CURRENT_VERSION .'</h1>';
      echo '<p>Software Wiki moderno escrito em PHP e que utiliza o Twitter Bootstrap e a Monzey Framework. Por James Peret.</p>';
      echo '</div>';
    } else {
	  // Se uma página foi especificada
      $page = Page::find($_GET['file']);
      if($page) {
      	  // Carregar a página do banco de dados
		  echo '<div class="hero-unit">';
	      echo '<h1>' . $_GET['file'] .'</h1>';
	      echo '<p>' . $page->content . '</p>';
	      echo '</div>';
	  } else {
	  	  // Mostrar página inexistente
		  echo '<div class="hero-unit">';
	      echo '<h1>' . $_GET['file'] .'</h1>';
	      echo '<p>Está pagina não existe.</p>';
	      echo '<p><a class="btn btn-primary btn-large" href="../edit_page.php?file=' . $_GET['file'] .'">Criar Pagina</a></p>';
	      echo '</div>';
	  }
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
    <script src="../assets/js/jquery.js"></script>
    <script src="../assets/js/bootstrap-transition.js"></script>
    <script src="../assets/js/bootstrap-alert.js"></script>
    <script src="../assets/js/bootstrap-modal.js"></script>
    <script src="../assets/js/bootstrap-dropdown.js"></script>
    <script src="../assets/js/bootstrap-scrollspy.js"></script>
    <script src="../assets/js/bootstrap-tab.js"></script>
    <script src="../assets/js/bootstrap-tooltip.js"></script>
    <script src="../assets/js/bootstrap-popover.js"></script>
    <script src="../assets/js/bootstrap-button.js"></script>
    <script src="../assets/js/bootstrap-collapse.js"></script>
    <script src="../assets/js/bootstrap-carousel.js"></script>
    <script src="../assets/js/bootstrap-typeahead.js"></script>

  </body>
</html>
