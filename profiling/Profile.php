<?php

class Profile {
	//Reference to the calling controller.
	private $ctrl=null;
	
	//Stores the reference to the caller.
	function __construct($ref) {
		$this->ctrl=$ref;
	}
	
	//Create a profile for a specific account. The data is accepted as an associative array.
	function createProfile($accno,$data) {
		ErrorHandler::reset();
		$keys=array_keys($data);
		$values=array();
		foreach($keys as $k) array_push($values,$data[$k]);
		array_push($keys,'acc_no');
		array_push($values,$accno);
		Database::add('profile',$keys,$values);
		$attr=array('alias','email','sex','dob','location');
		foreach($attr as $a) Database::add('privacy',array('acc_no','infofield','restriction'),array($accno,$a,0));
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		else return array(true,null);
	}
	
	//Sets an avatar for the profile.
	function setAvatar($accno,$img) {
		ErrorHandler::reset();
		$iminfo=getimagesize($img);
		$imgdata=addslashes(file_get_contents($img));
		Database::add('images',array('type','imgdata','width','height','bits'),array($iminfo['mime'],$imgdata,$iminfo[0],$iminfo[1],$iminfo['bits']));
		$newid=mysql_insert_id();
		$old=Database::get('profile','avatar',"acc_no=".$accno);
		if($old && $old[0]['avatar']) $old=$old[0]['avatar'];
		if($old && $old>1) Database::remove('images',"img_id=".$old);
		Database::update('profile',array('avatar'),array($newid),"acc_no=".$accno);
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		else return array(true,null);
	}
	
	//Removes a profile from the system.
	function deleteProfile($accno) {
		ErrorHandler::reset();
		Database::remove('profile',"acc_no=".$accno);
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		else return array(true,null);
	}
	
	//Updates a profile.
	function updateProfile($accno,$data) {
		ErrorHandler::reset();
		$keys=array_keys($data);
		$values=array();
		foreach($keys as $k) array_push($values,$data[$k]);
		Database::update('profile',$keys,$values,"acc_no=".$accno);
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		else return array(true,null);
	}
	
	//Fetches profile information. The attributes provided fetch specific data. If nothing is provided, the entire profile is returned.
	function fetchProfile($accno,$attrs) {
		ErrorHandler::reset();
		$cnt=func_num_args();
		if($cnt==1) $result=Database::get('profile','*',"acc_no=".$accno);
		else {
			if(in_array('avatar',$attrs)) array_push($attrs,'imgdata');
			$cols=implode(',',$attrs);
			$result=Database::get(sprintf('profile,%simages',Database::getPrefix()),$cols,"avatar=img_id and acc_no=".$accno);
		}
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		else return array(true,$result);
	}
}

?>
