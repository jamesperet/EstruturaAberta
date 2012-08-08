<?php

require_once(LIB_PATH.DS.'database.php');

class Comment extends DatabaseObject {

	protected static $table_name = "comments";
	protected static $db_fields = array('id', 'file_id', 'creation_date', 'user_id', 'comment', 'object_id');   
	public $id;
	public $file_id;
	public $creation_date;
	public $user_id;
	public $comment;
	public $object_id;

	public static function add_comment($file_id, $object_id) {
		$comment = new Comment();
		$comment->file_id = $file_id;
		$dt = new DateTime("now");
		$date = $dt->format('Y-m-d H:i:sP');
		$comment->creation_date = $date;
		$comment->user_id = $_SESSION['user_id'];
		$comment->comment =  $_POST['comment'];
		if($object_id) {
			$comment->object_id = $object_id;
		}
		$comment->save();
	}

}