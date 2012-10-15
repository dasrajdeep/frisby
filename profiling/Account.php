<?php

class Account {
	//Reference to the calling controller.
	private $ctrl=null;
	
	//Stores the reference to the caller.
	function __construct($ref) {
		$this->ctrl=$ref;
	}
	
	//Creates a new account.
	function createAccount($userid=null) {
		ErrorHandler::reset();
		Database::add('accounts',array('acc_id'),array($userid));
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		else return array(true,null);
	}
	
	//Removes an account.
	function deleteAccount($accno) {
		ErrorHandler::reset();
		Database::remove('accounts',"acc_no=".$accno);
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		else return array(true,null);
	}
	
	//Sets an user ID explicitly.
	function setUserID($accno,$userid) {
		ErrorHandler::reset();
		Database::update('accounts',array('acc_id'),array($userid),"acc_no=".$accno);
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		else return array(true,null);
	}
}

?>
