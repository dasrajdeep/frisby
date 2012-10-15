<?php

class Outbox {
	//Reference to the calling controller.
	private $ctrl=null;
	
	//Stores the reference to the caller.
	function __construct($ref) {
		$this->ctrl=$ref;
	}
	
	//Fetches the current outbox.
	function fetchOutbox($accno) {}
	
	//Deletes messages from outbox. If no ids are specified, deletes the entire outbox.
	function deleteOutboxMessages($accno,$idlist) {}
}

?>
