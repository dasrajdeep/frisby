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
		$patterns=array();
		foreach($keys as $k) if($k!='type' && $k!='creationdate') array_push($patterns,sprintf("%s like '%%%s%%'",$k,$querydata[$k]));
		if(isset($querydata['type'])) array_push($patterns,"type=".$querydata['type']);
		if(isset($querydata['creationdate'])) array_push($patterns,"creationdate>=".$querydata['creationdate']);
		$matcher=implode(' and ',$patterns);
		$set=Database::get('groups','*',$matcher);
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		return array(true,$set);
	}
}

?>
