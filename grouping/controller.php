<?php

class GroupingController extends Controller {
	
	function __construct() {
		//Method associations with sub-modules.
		$this->assoc['createGroup']='Group';
		$this->assoc['deleteGroup']='Group';
		$this->assoc['updateGroup']='Group';
		$this->assoc['addMember']='GroupMembers';
		$this->assoc['deleteMember']='GroupMembers';
		$this->assoc['updatePrivilege']='GroupMembers';
	
		//Locations of the sub-modules.
		$this->loc['Group']='Group.php';
		$this->loc['GroupMembers']='GroupMembers.php';
	}
	
	//The master method to invoke the appropriate method.
	function invoke($method,$data) {
		//Loads the sub-module if the method is registered with the controller.		
		if(!$this->loadSubModule($method)) return array(false,ErrorHandler::fetchTrace());
		
		//Invoke method of sub-module.
	}
}

?>
