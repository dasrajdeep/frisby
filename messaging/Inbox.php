<?php

class Inbox {
	//Reference to the calling controller.
	private $ctrl=null;
	
	//Stores the reference to the caller.
	function __construct($ref) {
		$this->ctrl=$ref;
	}
	
	//Fetches messages from inbox. If no ids are specified, fetches entire inbox.
	function fetchInbox($accno,$idlist) {}
	
	//Fetches unread messages.
	function fetchUnread($accno) {}
	
	//Marks messages as read.
	function markRead($msgid) {}
	
	//Deletes messages from inbox. If no identifiers are specified, deletes entire inbox.
	function deleteInboxMessages($accno,$idlist) {}
}

?>
