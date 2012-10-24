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
		$set=Database::get('messages','*',"status in (0,1,3,9,11) and sender=".$accno);
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		return array(true,$set);
	}
	
	//Deletes messages from outbox. If no ids are specified, deletes the entire outbox.
	function deleteOutboxMessages($idlist,$accno) {
		ErrorHandler::reset();
		$set=implode(',',$idlist);
		if(count($idlist)>0) Database::query(sprintf("update %smessages set status=status+4 where status in (0,1,3,9,11) and msg_id in (%s)",Database::getPrefix(),$set));
		else Database::query(sprintf("update %smessages set status=status+4 where status in (0,1,3,9,11) and sender=%s",Database::getPrefix(),$accno));
		Database::remove('messages',"status in (4,13,15)");
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		else return array(true,null);
	}
}

?>
