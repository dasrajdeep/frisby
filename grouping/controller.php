<?php

class GroupingController extends Controller {
	
	function __construct() {
		//Method associations with sub-modules.
		$this->assoc['createGroup']='Group';
		$this->assoc['deleteGroup']='Group';
		$this->assoc['updateGroup']='Group';
		$this->assoc['fetchGroup']='Group';
		$this->assoc['addMember']='GroupMembers';
		$this->assoc['deleteMember']='GroupMembers';
		$this->assoc['updatePrivilege']='GroupMembers';
		$this->assoc['fetchMembers']='GroupMembers';
	
		//Locations of the sub-modules.
		$this->loc['Group']='Group.php';
		$this->loc['GroupMembers']='GroupMembers.php';
	}
}

?>
