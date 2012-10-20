<?php

require_once(LIB_PATH.DS.'database.php');

class NavLink extends DatabaseObject {

	protected static $table_name = "nav_links";
	protected static $db_fields = array('id', 'name', 'page_id', 'order');   
	public $id;
	public $name;
	public $page_id;
	public $order;

}

?>