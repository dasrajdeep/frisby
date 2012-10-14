<?php

class Account {
	//Reference to the calling controller.
	private $ctrl=null;
	
	//Stores the reference to the caller.
	function __construct($ref) {
		$this->ctrl=$ref;
	}
	
	//Creates a new account.
	function createAccount($userid=null) {}
	
	//Removes an account.
	function deleteAccount($accno) {}
	
	//Sets an user ID explicitly.
	function setUserID($accno,$userid) {}
}

?>
