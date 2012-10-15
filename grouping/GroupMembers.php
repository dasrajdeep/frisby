<?php

class GroupMembers {
	//Reference to the calling controller.
	private $ctrl=null;
	
	//Stores the reference to the caller.
	function __construct($ref) {
		$this->ctrl=$ref;
	}
	
	//Adds a member to a group.
	function addMember($accno,$grpid,$type) {}
	
	//Deletes a member from a group.
	function deleteMember($accno,$grpid) {}
	
	//Change privileges for a group member.
	function updatePrivilege($accno,$grpid,$type) {}
}

?>
