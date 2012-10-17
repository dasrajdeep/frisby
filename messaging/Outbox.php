<?php

class Outbox {
	//Reference to the calling controller.
	private $ctrl=null;
	
	//Stores the reference to the caller.
	function __construct($ref) {
		$this->ctrl=$ref;
	}
	
	//Fetches the current outbox.
	function fetchOutbox($accno) {
		ErrorHandler::reset();
		$set=Database::get('messages','*',"sender=".$accno);
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		return array(true,$set);
	}
	
	//Deletes messages from outbox. If no ids are specified, deletes the entire outbox.
	function deleteOutboxMessages($idlist,$accno) {
		ErrorHandler::reset();
		$set=implode(',',$idlist);
		if(count($idlist)>0) Database::remove('messages',sprintf("msg_id in (%s)",$set));
		else Database::remove('messages',"sender=".$accno);
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		else return array(true,null);
	}
}

?>
