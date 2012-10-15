<?php

class GroupSearch {
	//Reference to the calling controller.
	private $ctrl=null;
	
	//Stores the reference to the caller.
	function __construct($ref) {
		$this->ctrl=$ref;
	}
	
	//Searches for groups or communities within the network.
	function searchGroup($query) {}
}

?>
