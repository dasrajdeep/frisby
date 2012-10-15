<?php

class Read {
	//Reference to the calling controller.
	private $ctrl=null;
	
	//Stores the reference to the caller.
	function __construct($ref) {
		$this->ctrl=$ref;
	}
	
	//Fetches post(s) from the database.
	function fetchPosts($node,$age) {}
	
	//Gets a specific post.
	function getPost($postid) {}
}

?>
