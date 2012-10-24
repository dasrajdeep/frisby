<?php

class Event {
	//Reference to the calling controller.
	private $ctrl=null;
	
	//Stores the reference to the caller.
	function __construct($ref) {
		$this->ctrl=$ref;
	}
	
	//Fires an event explicitly.
	function fireEvent() {}
	
	//Fetches events of types defined in a given array.
	function fetchEvents() {}
}

?>
