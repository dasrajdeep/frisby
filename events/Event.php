<?php

class Event {
	//Reference to the calling controller.
	private $ctrl=null;
	
	//Stores the reference to the caller.
	function __construct($ref) {
		$this->ctrl=$ref;
	}
	
	//Fires an event explicitly.
	function fireEvent($name,$src,$dest=null) {
		ErrorHandler::reset();
		$pre=Database::getPrefix();
		Database::query(sprintf("insert into %sevent_log (event,origin,target) values ((select event_id from %sevents where event_name=%s),%s,%s)",$pre,$pre,$name,$src,$dest));
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		else return array(true,null);
	}
	
	//Updates event status of events.
	function updateStatus($events,$status) {
		ErrorHandler::reset();
		$ids=implode(',',$events);
		Database::update('event_log',array('status'),array($status),sprintf("log_id in (%s)",$ids));
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		else return array(true,null);
	}
	
	//Fetches events of specific category.
	function fetchEventsByCategory($category,$age,$status=null) {
		ErrorHandler::reset();
		$pre=Database::getPrefix();
		if($status) $set=Database::get('event_log','*',sprintf("event in (select event_id from %sevents where category='%s') and timestamp>='%s' and status=%s",$pre,$category,$age,$status));
		else $set=Database::get('event_log','*',sprintf("event in (select event_id from %sevents where category='%s') and timestamp>='%s'",$pre,$category,$age));
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		else return array(true,$set);
	}
	
	//Fetches events of a specific origin/target.
	function fetchEventsByEntity($orig=null,$targ=null,$age) {
		ErrorHandler::reset();
		if(!$orig and !$targ) return array(true,null);
		$filters=array();
		if($orig) array_push($filters,"origin=".$orig);
		if($targ) array_push($filters,"target=".$targ);
		$set=Database::get('event_log','*',sprintf("%s and timestamp>='%s'",implode(' and ',$filters),$age));
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		else return array(true,$set);
	}
}

?>
