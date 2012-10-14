<?php

class EventHandler {
	//Holds the various event definitions.
	private static $events;
	
	//Initializes the event handler.
	static function init() {
		require_once('config/events.inc');
		self::$events=$events;
	}
	
	//Logs the events that are fired.
	static function fire($event,$source,$target) {
		$type=null;
		for($i=0;$i<count(self::$events);$i++) {
			if(array_key_exists($event,self::$events[$i])) $type=$i;
		} 
		if($type==null) {
			ErrorHandler::fire('evt','Event does not exist or is not registered.');
			return;
		}
		Database::add('events',array('type','timestamp','description','origin','target'),array($i,time(),self::$events[$i][$event],$source,$target));
	}
}

?>
