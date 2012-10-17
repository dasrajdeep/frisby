<?php

class GroupMembers {
	//Reference to the calling controller.
	private $ctrl=null;
	
	//Stores the reference to the caller.
	function __construct($ref) {
		$this->ctrl=$ref;
	}
	
	//Adds a member to a group.
	function addMember($accno,$grpid,$type=0) {
		ErrorHandler::reset();
		Database::add('group_memebers',array('member_id','group_id','type','joindate'),array($accno,$grpid,$type,date('Y-m-d')));
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		else return array(true,null);
	}
	
	//Deletes a member from a group.
	function deleteMember($accno,$grpid) {
		ErrorHandler::reset();
		Database::remove('group_members',sprintf("member_id=%s and group_id=%s",$accno,$grpid));
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		else return array(true,null);
	}
	
	//Change privileges for a group member.
	function updatePrivilege($accno,$grpid,$type) {
		ErrorHandler::reset();
		Database::update('group_members',array('type'),array($type),sprintf("member_id=%s and group_id=%s",$accno,$grpid));
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		else return array(true,null);
	}
}

?>