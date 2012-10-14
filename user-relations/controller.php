<?php

class UserRelationsController extends Controller {
	
	function __construct() {
		//Method associations with sub-modules.
		$this->assoc['']='';
	
		//Locations of the sub-modules.
		$this->loc['']='';
	}
	
	//The master method to invoke the appropriate method.
	function invoke($method,$data) {
		//Loads the sub-module if the method is registered with the controller.		
		if(!$this->loadSubModule($method)) return array(false,ErrorHandler::fetchTrace());
		
		//Invoke method of sub-module.
	}
}

?>
