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
		Database::add('messages',array('sender','receiver','textdata','timestamp','status'),array($sender,$receiver,$msg,time(),1));
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		else return array(true,null);
	}
	
	//Save message as draft.
	function saveDraft($sender,$receiver,$msg) {
		ErrorHandler::reset();
		Database::add('messages',array('sender','receiver','textdata','timestamp','status'),array($sender,$receiver,$msg,time(),0));
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		else return array(true,null);
	}
}

?>
