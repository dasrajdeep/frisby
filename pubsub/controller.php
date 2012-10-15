<?php

class PubSubController extends Controller {
	
	function __construct() {
		//Method associations with sub-modules.
		$this->assoc['createPost']='Publish';
		$this->assoc['deletePost']='Publish';
		$this->assoc['fetchPosts']='Read';
		$this->assoc['getPost']='Read';
	
		//Locations of the sub-modules.
		$this->loc['Publish']='Publish.php';
		$this->loc['Read']='Read.php';
	}
}

?>
