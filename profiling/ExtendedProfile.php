<?php

class ExtendedProfile {
	//Reference to the calling controller.
	private $ctrl=null;
	
	//Stores the reference to the caller.
	function __construct($ref) {
		$this->ctrl=$ref;
	}
	
	//Registers a new profile attribute. Adds privacy settings.
	function registerProfileAttribute($name,$datatype) {
		ErrorHandler::reset();
		Database::query(sprintf("alter table %sprofile add column %s %s",Database::getPrefix(),$name,$datatype));
		$set=Database::get('privacy','distinct acc_no as acc',false);
		foreach($set as $s) Database::add('privacy',array('acc_no','infofield'),array($s['acc'],$name));
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		else return array(true,null);
	}
	
	//Unregisters a profile attribute.
	function unregisterProfileAttribute($name) {
		ErrorHandler::reset();
		Database::query(sprintf("alter table %sprofile drop column %s",Database::getPrefix(),$name));
		Database::remove('privacy',sprintf("infofield='%s'",$name));
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		else return array(true,null);
	}
	
	//Fetches all the profile attribute names.
	function getAttributeNames() {
		ErrorHandler::reset();
		$p=Database::query("desc %sprofile");
		$names=array();
		while($r=mysql_fetch_assoc($p)) array_push($names,$r['Field']);
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		else return array(true,$names);

	}
}

?>
