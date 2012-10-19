<?php

require_once(LIB_PATH.DS.'database.php');

class InventoryItem extends DatabaseObject {

	protected static $table_name = "inventory_items";
	protected static $db_fields = array('id', 'name', 'stock', 'place', 'cost', 'suplier');   
	public $id;
	public $name;
	public $stock;
	public $place;
	public $cost;
	public $suplier;

}

?>