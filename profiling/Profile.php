<?php

class Profile {
	//Reference to the calling controller.
	private $ctrl=null;
	
	//Stores the reference to the caller.
	function __construct($ref) {
		$this->ctrl=$ref;
	}
	
	//Create a profile for a specific account. The data is accepted as an associative array.
	function createProfile($accno,$data) {}
	
	//Removes a profile from the system.
	function deleteProfile($accno) {}
	
	//Updates a profile.
	function updateProfile($accno,$data) {}
	
	//Fetches profile information. The attributes provided fetch specific data. If nothing is provided, the entire profile is returned.
	function fetchProfile($accno,$attrs) {}
}

?>
