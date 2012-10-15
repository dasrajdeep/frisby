<?php

class UserRelations {
	//Reference to the calling controller.
	private $ctrl=null;
	
	//Stores the reference to the caller.
	function __construct($ref) {
		$this->ctrl=$ref;
	}
	
	//Create a new user relation.
	function createRelation($accno1,$accno2) {}
	
	//Confirm requested relation.
	function confirmRelation($accno1,$accno2) {}
}

?>
