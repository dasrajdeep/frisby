<?php

class ProfileController extends Controller {
	
	function __construct() {
		//Method associations with sub-modules.
		$this->assoc['createAccount']='Account';
		$this->assoc['deleteAccount']='Account';
		$this->assoc['setUserID']='Account';
		$this->assoc['createProfile']='Profile';
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
	
	//The master method to invoke the appropriate method.
	function invoke($method,$data) {
		//Loads the sub-module if the method is registered with the controller.		
		$submod=$this->loadSubModule($method);	
		if($submod==null) return array(false,ErrorHandler::fetchTrace());
		
		//Invoke method of sub-module.
	}
}

?>
