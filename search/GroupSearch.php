<?php

class GroupSearch {
	//Reference to the calling controller.
	private $ctrl=null;
	
	//Stores the reference to the caller.
	function __construct($ref) {
		$this->ctrl=$ref;
	}
	
	//Searches for groups or communities within the network.
	function searchGroup($querydata) {
		ErrorHandler::reset();
		$keys=array_keys($querydata);
		$matcher='';
		foreach($keys as $k) {
			if($k=='type' || $k=='creationdate') continue;
			if($matcher=='') $matcher.=sprintf("%s like '%%%s%%'",$k,$querydata[$k]);
			else $matcher.=sprintf(" and %s like '%%%s%%'",$k,$querydata[$k]);
		}
		if(isset($querydata['type'])) $matcher.=" and type=".$querydata['type'];
		if(isset($querydata['creationdate'])) $matcher.=" and creationdate>=".$querydata['creationdate'];
		$set=Database::get('groups','*',$matcher); 
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		return array(true,$set);
	}
}

?>
