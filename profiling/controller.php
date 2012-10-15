<?php

class ProfileController extends Controller {
	
	function __construct() {
		//Method associations with sub-modules.
		$this->assoc['createAccount']='Account';
		$this->assoc['deleteAccount']='Account';
		$this->assoc['setUserID']='Account';
		$this->assoc['createProfile']='Profile';
		$this->assoc['setAvatar']='Profile';
		$this->assoc['deleteProfile']='Profile';
		$this->assoc['updateProfile']='Profile'; 
		$this->assoc['fetchProfile']='Profile';
		$this->assoc['setPrivacy']='Privacy';
		$this->assoc['getPrivacy']='Privacy';
		
		//Locations of the sub-modules.
		$this->loc['Account']='Account.php';
		$this->loc['Profile']='Profile.php';
		$this->loc['Privacy']='Privacy.php';
	}
}

?>
