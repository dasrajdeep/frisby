<?php

class Inbox {
	//Reference to the calling controller.
	private $ctrl=null;
	
	//Stores the reference to the caller.
	function __construct($ref) {
		$this->ctrl=$ref;
	}
	
	//Fetches messages from inbox.
	function fetchInbox($accno) {
		ErrorHandler::reset();
		$set=Database::get('messages','*',"status in (1,3,5,7) and receiver=".$accno);
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		return array(true,$set);
	}
	
	//Fetches unread messages.
	function fetchUnread($accno) {
		ErrorHandler::reset();
		$set=Database::get('messages','*',"status in (1,5) and receiver=".$accno);
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		return array(true,$set);
	}
	
	//Marks messages as read.
	function markRead($msgids) {
		ErrorHandler::reset();
		$set=implode(',',$msgids);
		Database::query(sprintf("update %smessages set status=status+2 where msg_id in (%s)",Database::getPrefix(),$set));
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		else return array(true,null);
	}
	
	//Deletes messages from inbox. If no identifiers are specified, deletes entire inbox.
	function deleteInboxMessages($idlist,$accno) {
		ErrorHandler::reset();
		$set=implode(',',$idlist);
		if(count($idlist)>0) Database::query(sprintf("update %smessages set status=status+8 where status in (1,3,5,7) and msg_id in (%s)",Database::getPrefix(),$set));
		else Database::query(sprintf("update %smessages set status=status+8 where status in (1,3,5,7) and receiver=%s",Database::getPrefix(),$accno));
		Database::remove('messages',"status in (13,15)");
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		else return array(true,null);
	}
}

?>
