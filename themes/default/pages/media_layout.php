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
