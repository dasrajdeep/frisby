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
		$matcher='';
		foreach($keys as $k) {
			if($matcher=='') $matcher.=sprintf("%s like '%%%s%%'",$k,$querydata[$k]);
			else $matcher.=sprintf(" and %s like '%%%s%%'",$k,$querydata[$k]);
		}
		$set=Database::get('profile','*',$matcher);
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		return array(true,$set);
	}
	
	//Searches for members within a group or friends chain.
	function searchMembers($querydata,$domain) {
		ErrorHandler::reset();
		$matcher='';
		foreach($keys as $k) {
			if($matcher=='') $matcher.=sprintf("%s like '%%%s%%'",$k,$querydata[$k]);
			else $matcher.=sprintf(" and %s like '%%%s%%'",$k,$querydata[$k]);
		}
		if(isset($domain['group_id'])) $set=Database::get('profile,group_members','profile.*',$matcher." and member_id=acc_no and group_id=".$domain['group_id']);
		if(isset($domain['user_id'])) $set=Database::get('profile','*',$matcher.sprintf(" and acc_no in (select user1 as user from user_relations where user2=%s and status=1 union select user2 as user from user_relations where user1=%s and status=1)",$domain['user_id'],$domain['user_id']));
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		return array(true,$set);
	}
}

?>
