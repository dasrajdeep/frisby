<?php

class Privacy {
	//Reference to the calling controller.
	private $ctrl=null;
	
	//Stores the reference to the caller.
	function __construct($ref) {
		$this->ctrl=$ref;
	}
	
	//Sets the privacy attributes for all or specific information.
	function setPrivacy($accno,$settings) {
		ErrorHandler::reset();
		$keys=array_keys($settings);
		foreach($keys as $k) Database::update('privacy',array('restriction'),array($settings[$k]),sprintf("acc_no=%s and infofield='%s'",$accno,$k));
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		else return array(true,null);
	}
	
	//Gets privacy settings. A set of information attributes are provided to specify the requirement.
	function getPrivacy($accno,$infoset) {
		ErrorHandler::reset();
		$set=null;
		if(count($infoset)>0) implode(',',$infoset);
		if($set) $result=Database::get('privacy','infofield,restriction',sprintf("acc_no=%s and infofield in (%s)",$accno,$set));
		else $result=Database::get('privacy','infofield,restriction',"acc_no=".$accno);
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		return array(true,$result);
	}
}

?>
