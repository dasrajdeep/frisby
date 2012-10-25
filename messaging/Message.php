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
		EventHandler::fire('sentmessage',$sender,$receiver);
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
		$set=Database::get('messages','sender,receiver',"msg_id=".$msgid);
		EventHandler::fire('sentmessage',$set[0]['sender'],$set[0]['receiver']);
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		else return array(true,null);
	}
}

?>
