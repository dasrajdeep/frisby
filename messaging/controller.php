<?php

class MessagingController extends Controller {
	
	function __construct() {
		//Method associations with sub-modules.
		$this->assoc['sendMessage']='Message';
		$this->assoc['saveDraft']='Message';
		$this->assoc['forwardMessage']='Message';
		$this->assoc['fetchOutbox']='Outbox';
		$this->assoc['deleteOutboxMessages']='Outbox';
		$this->assoc['fetchInbox']='Inbox';
		$this->assoc['fetchUnread']='Inbox';
		$this->assoc['markRead']='Inbox';
		$this->assoc['deleteInboxMessages']='Inbox';
	
		//Locations of the sub-modules.
		$this->loc['Message']='Message.php';
		$this->loc['Outbox']='Outbox.php';
		$this->loc['Inbox']='Inbox.php';
	}
	
	//The master method to invoke the appropriate method.
	function invoke($method,$data) {
		//Loads the sub-module if the method is registered with the controller.		
		if(!$this->loadSubModule($method)) return array(false,ErrorHandler::fetchTrace());
		
		//Invoke method of sub-module.
	}
}

?>
