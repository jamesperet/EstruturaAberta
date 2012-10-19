<?php
	if($page->page_type == 'page' && $page->content != 'list_pages'){
  	  // Carregar a página do banco de dados
      echo '<div class="row"><div class="span12">';
      echo markdown($page->content);
      echo '</div></div>';
    } else { 			
		echo '<div class="page-header"><h1>Lista de páginas</h1></div>';
		echo '<table class="table table-bordered"><tbody><thead><tr><th>Página</th><th>Autor</th><th>data</th></tr></thead>';				
		$pages = Page::find_all();
			foreach($pages as $page) {
				$user = User::find_by_id($page->creator_id);
				if($_GET['tag']){
					$tag = Tag::find($_GET['tag']);
					if(ItemTag::find_object_tag($page->id, $tag->id, 'page')){
						echo '<tr><td><a href="' . build_link($page->id) . '">' . $page->name . '</a></td><td>' . $user->full_name() .'</td><td>' . getElapsedTime($page->creation_date) .'</tr>';
					}
				} else {
					echo '<tr><td><a href="' . build_link($page->id) . '">' . $page->name . '</a></td><td>' . $user->full_name() .'</td><td>' . getElapsedTime($page->creation_date) .'</tr>';
				}
			}
		echo '</tbody></table>';
	}
?>