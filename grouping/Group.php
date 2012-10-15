<?php

class Group {
	//Reference to the calling controller.
	private $ctrl=null;
	
	//Stores the reference to the caller.
	function __construct($ref) {
		$this->ctrl=$ref;
	}
	
	//Creates a new group.
	function createGroup($creator,$name,$desc,$type=0) {}
	
	//Remove group.
	function deleteGroup($grpid) {}
	
	//Change group attributes. Data is accepted as an associative array.
	function updateGroup($grpid,$data) {}
}

?>
