<?php

class Read {
	//Reference to the calling controller.
	private $ctrl=null;
	
	//Stores the reference to the caller.
	function __construct($ref) {
		$this->ctrl=$ref;
	}
	
	//Fetches post(s) from the database. Currently supports only images for MIME.
	function fetchPosts($node,$age) {
		ErrorHandler::reset();
		$fields='posts.*,images.imgdata';
		$criterion=sprintf("node=%s and timestamp>=%s and mime=img_id",$node,$age);
		$set=Database::get('posts,images',$fields,$criterion);
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		return array(true,$set);
	}
	
	//Gets a specific post.
	function getPost($postid) {
		ErrorHandler::reset();
		$fields='posts.*,images.imgdata';
		$criterion=sprintf("post_id=%s and mime=img_id",$postid);
		$set=Database::get('posts,images',$fields,$criterion);
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		return array(true,$set);
	}
}

?>
