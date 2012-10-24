<?php

class PeopleSearch {
	//Reference to the calling controller.
	private $ctrl=null;
	
	//Stores the reference to the caller.
	function __construct($ref) {
		$this->ctrl=$ref;
	}
	
	//Search people in the network.
	function searchPeople($querydata) {
		ErrorHandler::reset();
		$keys=array_keys($querydata);
		$patterns=array();
		foreach($keys as $k) if($k!='name') array_push($patterns,sprintf("%s like '%%%s%%'",$k,$querydata[$k]));
		if(array_key_exists('name',$querydata)) array_push($patterns,sprintf("concat(firstname,' ',middlename,' ',lastname) like '%%%s%%'",$querydata['name']));
		$matcher=implode(' and ',$patterns);
		$set=Database::get('profile','*',$matcher);
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		return array(true,$set);
	}
	
	//Searches for members within a group or friends chain.
	function searchMembers($querydata,$domain) {
		ErrorHandler::reset();
		$keys=array_keys($querydata);
		$patterns=array();
		foreach($keys as $k) if($k!='name') array_push($patterns,sprintf("%s like '%%%s%%'",$k,$querydata[$k]));
		if(array_key_exists('name',$querydata)) array_push($patterns,sprintf("concat(firstname,' ',middlename,' ',lastname) like '%%%s%%'",$querydata['name']));
		$pre=Database::getPrefix();
		if(isset($domain['group_id'])) array_push($patterns,sprintf("acc_no in (select member_id from %sgroup_members where group_id=%s)",$pre,$domain['group_id']));
		if(isset($domain['user_id'])) array_push($patterns,sprintf("acc_no in (select user1 as user from %suser_relations where user2=%s and status=1 union select user2 as user from %suser_relations where user1=%s and status=1)",$pre,$domain['user_id'],$pre,$domain['user_id']));
		$matcher=implode(' and ',$patterns);
		$set=Database::get('profile','*',$matcher);
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		return array(true,$set);
	}
}

?>
