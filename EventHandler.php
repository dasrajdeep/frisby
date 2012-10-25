<?php

class EventHandler {
	
	//Initializes the event handler.
	static function init() {
		//
	}
	
	//Logs the events that are fired.
	static function fire($event,$source,$target=null) {
		$desc='';
		$pre=Database::getPrefix();
		$values=sprintf("(select event_id from %sevents where event_name='%s'),%s,'%s',%s",$pre,$event,$source,$desc,$target);
		Database::query("insert into %sevent_log (event,source,description,target) values (%s)",$pre,$values);
	}
}

?>
