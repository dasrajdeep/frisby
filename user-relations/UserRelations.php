<?php

class UserRelations {
	//Reference to the calling controller.
	private $ctrl=null;
	
	//Stores the reference to the caller.
	function __construct($ref) {
		$this->ctrl=$ref;
	}
	
	//Create a new user relation.
	function createRelation($accno1,$accno2,$type=0) {
		ErrorHandler::reset();
		Database::add('user_relations',array('user1','user2','type','status'),array($accno1,$accno2,$type,0));
		EventHandler::fire('sentfriendrequest',$accno1,$accno2);
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		else return array(true,null);
	}
	
	//Confirm requested relation.
	function confirmRelation($accno1,$accno2) {
		ErrorHandler::reset();
		Database::update('user_relations',array('status'),array(1),sprintf("(user1=%s and user2=%s) or (user2=%s and user1=%s)",$accno1,$accno2,$accno1,$accno2));
		EventHandler::fire('acceptedrequest',$accno1,$accno2);
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		else return array(true,null);
	}
	
	//Updates a user relation.
	function updateRelation($accno1,$accno2,$type) {
		ErrorHandler::reset();
		Database::update('user_relations',array('type'),array($type),sprintf("user1=%s and user2=%s",$accno1,$accno2));
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		else return array(true,null);
	}
	
	//Fetches information regarding a user relation.
	function fetchRelationInfo($accno1,$accno2) {
		ErrorHandler::reset();
		$set=Database::get('user_relations','status,type',sprintf("(user1=%s and user2=%s) or (user2=%s and user1=%s)",$accno1,$accno2,$accno1,$accno2));
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		else return array(true,$set[0]);
	}
}

?>
