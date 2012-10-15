<?php

class Search {
	//Reference to the calling controller.
	private $ctrl=null;
	
	//Stores the reference to the caller.
	function __construct($ref) {
		$this->ctrl=$ref;
	}
	
	//A generic search for specific information types. Domain is a list of areas to search for.
	function search($query,$domain) {}
}

?>
