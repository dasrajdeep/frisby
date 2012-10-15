<?php

class PeopleSearch {
	//Reference to the calling controller.
	private $ctrl=null;
	
	//Stores the reference to the caller.
	function __construct($ref) {
		$this->ctrl=$ref;
	}
	
	//Search people in the network.
	function searchPeople($query) {}
	
	//Searches for members within a group or friends chain.
	function searchMembers($query,$location) {}
}

?>
