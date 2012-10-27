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
		Database::add('group_members',array('member_id','group_id','type'),array($accno,$grpid,$type));
		EventHandler::fire('joinedgroup',$accno,$grpid);
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		else return array(true,null);
	}
	
	//Deletes a member from a group.
	function deleteMember($accno,$grpid) {
		ErrorHandler::reset();
		Database::remove('group_members',sprintf("member_id=%s and group_id=%s",$accno,$grpid));
		EventHandler::fire('leftgroup',$accno,$grpid);
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		else return array(true,null);
	}
	
	//Change privileges for a group member.
	function updatePrivilege($accno,$grpid,$type) {
		ErrorHandler::reset();
		Database::update('group_members',array('type'),array($type),sprintf("member_id=%s and group_id=%s",$accno,$grpid));
		if(type==2) EventHandler::fire('becamemoderator',$accno,$grpid);
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		else return array(true,null);
	}
	
	//Fetches members of a particular group.
	function fetchMembers($grpid) {
		ErrorHandler::reset();
		$set=Database::get('group_members','member_id,type,joindate',"group_id=".$grpid);
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		else return array(true,$set);
	}
}

?>
