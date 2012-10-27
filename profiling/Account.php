<?php

class Account {
	//Reference to the calling controller.
	private $ctrl=null;
	
	//Stores the reference to the caller.
	function __construct($ref) {
		$this->ctrl=$ref;
	}
	
	//Creates a new account.
	function createAccount($info,$status=0) {
		ErrorHandler::reset();
		$keys=array_keys($info);
		array_push($keys,'status');
		$values=array_values($info);
		array_push($values,$status);
		Database::add('accounts',$keys,$values);
		if($status>0) EventHandler::fire('joinednetwork',mysql_insert_id());
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		else return array(true,null);
	}
	
	//Removes an account.
	function deleteAccount($accno) {
		ErrorHandler::reset();
		EventHandler::fire('leftnetwork',$accno);
		Database::remove('accounts',"acc_no=".$accno);
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		else return array(true,null);
	}
	
	//Sets an user ID explicitly.
	function updateAccount($accno,$data) {
		ErrorHandler::reset();
		$keys=array_keys($data);
		$values=array();
		foreach($keys as $k) array_push($values,$data[$k]);
		Database::update('accounts',$keys,$values,"acc_no=".$accno);
		if(array_key_exists('status',$data) && $data['status']>0) EventHandler::fire('joinednetwork',$accno);
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		else return array(true,null);
	}
	
	//Fetches account information of a specific user.
	function fetchAccountInfo($accno) {
		ErrorHandler::reset();
		$set=Database::get('accounts','email,firstname,middlename,lastname,status',"acc_no=".$accno);
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		else return array(true,$set[0]);
	}
}

?>
