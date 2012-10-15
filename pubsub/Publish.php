<?php

class Publish {
	//Reference to the calling controller.
	private $ctrl=null;
	
	//Stores the reference to the caller.
	function __construct($ref) {
		$this->ctrl=$ref;
	}
	
	//Creates a new post.
	function createPost($accno,$node,$thread,$data) {}
	
	//Removes a post.
	function deletePost($postid) {}
}

?>
