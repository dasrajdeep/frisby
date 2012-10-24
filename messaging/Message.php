<?php

class Message {
	//Reference to the calling controller.
	private $ctrl=null;
	
	//Stores the reference to the caller.
	function __construct($ref) {
		$this->ctrl=$ref;
	}
	
	//Creates a new message.
	function sendMessage($sender,$receiver,$msg) {
		ErrorHandler::reset();
		Database::add('messages',array('sender','receiver','textdata','status'),array($sender,$receiver,$msg,1));
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		else return array(true,null);
	}
	
	//Save message as draft.
	function saveDraft($sender,$receiver,$msg) {
		ErrorHandler::reset();
		Database::add('messages',array('sender','receiver','textdata','status'),array($sender,$receiver,$msg,0));
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		else return array(true,null);
	}
	
	//Edit draft.
	function editDraft($msgid,$msg) {
		ErrorHandler::reset();
		Database::update('messages',array('textdata'),array($msg),"msg_id=".$msgid);
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		else return array(true,null);
	}
	
	//Send draft.
	function sendDraft($msgid) {
		ErrorHandler::reset();
		Database::update('messages',array('status'),array(1),"msg_id=".$msgid);
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		else return array(true,null);
	}
}

?>
