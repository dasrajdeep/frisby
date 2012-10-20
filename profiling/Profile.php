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
	function setAvatar($accno,$img,$type) {
		ErrorHandler::reset();
		$size=getimagesize($img);
		$raw=file_get_contents($img);
		$formed=addslashes($raw);
		$link=Database::add('images',array('type','size','imgdata'),array($type,$size,$formed));
		$newid=mysql_insert_id($link);
		$old=Database::get('profile','avatar',"acc_no=".$accno);
		if($old && $old[0]['avatar']) $old=$old[0]['avatar'];
		if($old) Database::remove('images',"img_id=".$old);
		Database::update('profile',array('avatar'),array($newid),"acc_no=".$accno);
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		else return array(true,null);
	}
	
	//Removes a profile from the system.
	function deleteProfile($accno) {
		ErrorHandler::reset();
		$ref=Database::get('profile','avatar',"acc_no=".$accno);
		if($ref[0]['avatar']) Database::remove('images',"img_id=".$ref[0]['avatar']);
		Database::remove('profile',"acc_no=".$accno);
		Database::remove('privacy',"acc_no=".$accno);
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
		$cols='*';
		if(count($attrs)>0) $cols=implode(',',$attrs);
		$result=Database::get('profile',$cols,"acc_no=".$accno);
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		else return array(true,$result);
	}
}

?>
