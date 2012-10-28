<?php
/**
 * This file contains the PeopleSearch class.
 * 
 * PHP version 5.3
 * 
 * LICENSE: This file is part of Frisby.
 * Frisby is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * Frisby is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with Frisby. If not, see <http://www.gnu.org/licenses/>. 
 * 
 * @category   PHP
 * @package    Frisby
 * @author     Rajdeep Das <das.rajdeep97@gmail.com>
 * @copyright  Copyright 2012 Rajdeep Das
 * @license    http://www.gnu.org/licenses/gpl.txt  The GNU General Public License
 * @version    GIT: v1.0
 * @link       https://github.com/dasrajdeep/frisby
 * @since      File available since Release 1.0
 */

/**
 * An instance of this class is used to search people within the social network.
 * 
 * <code>
 * require_once('PeopleSearch.php');
 * 
 * $search=new PeopleSearch();
 * $data=array('firstname'=>'someone');
 * $resultset=$search->searchPeople($data);
 * </code> 
 * 
 * @package frisby\search
 */
class PeopleSearch {
	/**
         * Contains a reference to the module controller
         * 
         * @var object
         */
	private $ctrl=null;
	
	/**
         * Passes a reference of the module controller to this object
         * 
         * @param object $ref 
         */
	function __construct($ref) {
		$this->ctrl=$ref;
	}
	
	/**
         * Searches for people within the entire network
         * 
         * @param array $querydata
         * @return array 
         */
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
	
	/**
         * Searches for people within a group or friend list
         * 
         * @param array $querydata
         * @param int $domain
         * @return array 
         */
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
