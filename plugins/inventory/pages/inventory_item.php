<?php
	$item = InventoryItem::find_by_id($page->object_id);
	echo '<h2>' . $item->name . ' (' . $item->stock . ')</h2>'; 
?>