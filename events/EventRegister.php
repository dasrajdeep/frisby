<?php

class EventRegister {
	//Reference to the calling controller.
	private $ctrl=null;
	
	//Stores the reference to the caller.
	function __construct($ref) {
		$this->ctrl=$ref;
	}
	
	//Registers a new event type.
	function registerEvent($name,$category,$desc='') {
		ErrorHandler::reset();
		Database::add('events',array('category','event_name','description'),array($category,$name,$desc));
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		else return array(true,null);
	}
	
	//Unregisters an event type.
	function unregisterEvent($name) {
		ErrorHandler::reset();
		Database::remove('events',sprintf("event_name='%s'",$name));
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		else return array(true,null);
	}
}

?>
