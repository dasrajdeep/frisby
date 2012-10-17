<?php

class Publish {
	//Reference to the calling controller.
	private $ctrl=null;
	
	//Stores the reference to the caller.
	function __construct($ref) {
		$this->ctrl=$ref;
	}
	
	//Creates a new post.
	function createPost($accno,$node,$thread,$data) {
		ErrorHandler::reset();
		//
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		else return array(true,null);
	}
	
	//Removes a post.
	function deletePost($postid) {
		ErrorHandler::reset();
		$pre=Database::get('posts','mime',"mime_type=1 and post_id=".$postid);
		if($pre) $pre=$pre[0]['mime'];
		if($pre) Database::remove('images',"img_id=".$pre);
		Database::remove('posts',"post_id=".$postid);
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		else return array(true,null);
	}
}

?>
