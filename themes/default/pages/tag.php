
  <?php
  	if($page->object_id){
  		$tag = Tag::find_by_id($page->object_id);
  		echo '<div class="page-header"><h1>' . $tag->name . ' <small>Páginas taggeadas</small></h1></div>';
  		echo '<table class="table table-bordered"><tbody><thead><tr><th>Página</th><th>Autor</th><th>data</th></tr></thead>';
  		$pages = Page::find_all();
		foreach($pages as $page) {
			$user = User::find_by_id($page->creator_id);
			if($tag){
				if(ItemTag::find_object_tag($page->id, $tag->id, 'page')){
					echo '<tr><td><a href="' . build_link($page->id) . '">' . $page->name . '</a></td><td>' . $user->full_name() .'</td><td>' . getElapsedTime($page->creation_date) .'</tr>';
				}
			} else {
				echo '<tr><td><a href="' . build_link($page->id) . '">' . $page->name . '</a></td><td>' . $user->full_name() .'</td><td>' . getElapsedTime($page->creation_date) .'</tr>';
			}
		}
		echo '</tbody></table>';
  	} else {
	  	echo '<div class="page-header"><h1>Tags</h1></div>';
	  	$all_tags = Tag::find_all();
      	foreach($all_tags as $item_tag){
      		$tagged_items = ItemTag::count_tags($item_tag->id);
       		echo '<a href="pages.php?tag='. $item_tag->name .'"><span class="label label-info">' . $item_tag->name . ' (' . $tagged_items . ')</span></a> ';
       	}
  	}
  ?>
  


    
