<?php

class Message {
	//Reference to the calling controller.
	private $ctrl=null;
	
	//Stores the reference to the caller.
	function __construct($ref) {
		$this->ctrl=$ref;
	}
	
	//Creates a new message.
	function sendMessage($sender,$receiver,$msg) {}
	
	//Save message as draft.
	function saveDraft($sender,$receiver,$msg) {}
	
	//Forwards messages.
	function forwardMessage($msgid,$receiver) {}
}

?>
