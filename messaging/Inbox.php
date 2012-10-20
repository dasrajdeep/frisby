<?php

class Inbox {
	//Reference to the calling controller.
	private $ctrl=null;
	
	//Stores the reference to the caller.
	function __construct($ref) {
		$this->ctrl=$ref;
	}
	
	//Fetches messages from inbox. If no ids are specified, fetches entire inbox.
	function fetchInbox($accno,$idlist) {
		ErrorHandler::reset();
		$idset=implode(',',$idlist);
		if(count($idlist)>0) $set=Database::get('messages','*',sprintf("receiver=%s and status>0 and status<5 and msg_id in (%s)",$accno,$idset));
		else $set=Database::get('messages','*',"status>0 and receiver=".$accno);
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		return array(true,$set);
	}
	
	//Fetches unread messages.
	function fetchUnread($accno) {
		ErrorHandler::reset();
		$set=Database::get('messages','*',"status=1 and receiver=".$accno);
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		return array(true,$set);
	}
	
	//Marks messages as read.
	function markRead($msgids) {
		ErrorHandler::reset();
		$set=implode(',',$msgids);
		Database::update('messages',array('status'),array(2),sprintf("msg_id in (%s)",$set));
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		else return array(true,null);
	}
	
	//Deletes messages from inbox. If no identifiers are specified, deletes entire inbox.
	function deleteInboxMessages($idlist,$accno) {
		ErrorHandler::reset();
		$set=implode(',',$idlist);
		if(count($idlist)>0) Database::update('messages',array('status'),array(5),sprintf("msg_id in (%s)",$set));
		else Database::update('messages',array('status'),array(5),"status>0 and receiver=".$accno);
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		else return array(true,null);
	}
}

?>
