<?php

class PostSearch {
	//Reference to the calling controller.
	private $ctrl=null;
	
	//Stores the reference to the caller.
	function __construct($ref) {
		$this->ctrl=$ref;
	}
	
	//Searches for all posts in the network containing a selected topic.
	function searchAllPosts($query) {}
	
	//Searches for posts within a group or any node.
	function searchNode($query) {}
}

?>
