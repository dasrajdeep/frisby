<?php

class Read {
	//Reference to the calling controller.
	private $ctrl=null;
	
	//Stores the reference to the caller.
	function __construct($ref) {
		$this->ctrl=$ref;
	}
	
	//Fetches post(s) from the database. Currently supports only images for MIME.
	function fetchPosts($nodetype,$node,$limit) {
		ErrorHandler::reset();
		$fields='post_id,publisher,textdata,timestamp,thread,type,mime_type,imgdata';
		$criterion=sprintf("nodetype=%s and node=%s and mime=img_id limit %s",$nodetype,$node,$limit);
		$set=Database::get(sprintf('posts,%simages',Database::getPrefix()),$fields,$criterion);
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		return array(true,$set);
	}
	
	//Gets a specific post.
	function getPost($postid) {
		ErrorHandler::reset();
		$fields='post_id,publisher,textdata,timestamp,thread,type,mime_type,imgdata';
		$criterion=sprintf("post_id=%s and mime=img_id",$postid);
		$set=Database::get(sprintf('posts,%simages',Database::getPrefix()),$fields,$criterion);
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		return array(true,$set);
	}
}

?>
