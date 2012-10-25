<?php

class Event {
	//Reference to the calling controller.
	private $ctrl=null;
	
	//Stores the reference to the caller.
	function __construct($ref) {
		$this->ctrl=$ref;
	}
	
	//Fires an event explicitly.
	function fireEvent($name,$src,$desc='',$dest) {
		ErrorHandler::reset();
		$pre=Database::getPrefix();
		Database::query(sprintf("insert into %sevent_log (event,origin,target,description) values ((select event_id from %sevents where event_name=%s),%s,%s,'%s')",$pre,$pre,$name,$src,$dest,$desc));
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		else return array(true,null);
	}
	
	//Fetches events of types defined in a given array.
	function fetchEvents($category,$age,$status=null) {
		ErrorHandler::reset();
		$cat=implode(',',$category);
		if($status) $set=Database::get('event_log','*',sprintf("category in (%s) and timestamp>='%s' and status=%s",$cat,$age,$status));
		else $set=Database::get('event_log','*',sprintf("category in (%s) and timestamp>='%s'",$cat,$age));
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		else return array(true,$set);
	}
}

?>
