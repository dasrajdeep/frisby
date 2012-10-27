<?php

class EventHandler {
	
	//Logs the events that are fired.
	static function fire($event,$source,$target=null) {
		$pre=Database::getPrefix();
		$values=sprintf("(select event_id from %sevents where event_name='%s'),%s,%s",$pre,$event,$source,$target);
		Database::query("insert into %sevent_log (event,source,target) values (%s)",$pre,$values);
	}
}

?>
