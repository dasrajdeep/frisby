<?php

class Group {
	//Reference to the calling controller.
	private $ctrl=null;
	
	//Stores the reference to the caller.
	function __construct($ref) {
		$this->ctrl=$ref;
	}
	
	//Creates a new group.
	function createGroup($creator,$name,$desc,$type=0) {
		ErrorHandler::reset();
		$ref=Database::add('groups',array('name','description','type','creationdate'),array($name,$desc,$type,date("Y-m-d")));
		if($ref) $ref=mysql_insert_id($ref);
		Database::add('group_members',array('member_id','group_id','type','joindate'),array($creator,$ref,1,date("Y-m-d")));
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		else return array(true,null);
	}
	
	//Remove group.
	function deleteGroup($grpid) {
		ErrorHandler::reset();
		Database::remove('groups',"group_id=".$grpid);
		Database::remove('group_members',"group_id=".$grpid);
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		else return array(true,null);
	}
	
	//Change group attributes. Data is accepted as an associative array.
	function updateGroup($grpid,$data) {
		ErrorHandler::reset();
		$keys=array_keys($data);
		$values=array();
		foreach($keys as $k) array_push($values,$data[$k]);
		Database::update('groups',$keys,$values,"group_id=".$grpid);
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		else return array(true,null);
	}
}

?>
