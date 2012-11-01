<?php
/**
 * This file contains the UserRelations class.
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
 * An instance of this class is used to manage user relations in the social network.
 * 
 * <code>
 * require_once('UserRelations.php');
 * 
 * $ur=new UserRelations();
 * $ur->createRelation(userid1,userid2,0);
 * </code> 
 * 
 * @package frisby\user-relations
 */
class UserRelations extends ModuleSupport {
	
	/**
         * Creates a new user relation.
         * 
         * @param int $accno1
         * @param int $accno2
         * @param int $type
         * @return null 
         */
	function createUserRelation($accno1,$accno2,$type=0) {
		Database::add('user_relations',array('user1','user2','type','status'),array($accno1,$accno2,$type,0));
		EventHandler::fireEvent('sentfriendrequest',$accno1,$accno2);
		return null;
	}
	
	/**
         * Confirms a user relation.
         * 
         * @param int $accno1
         * @param int $accno2
         * @return null 
         */
	function confirmUserRelation($accno1,$accno2) {
		Database::update('user_relations',array('status'),array(1),sprintf("(user1=%s and user2=%s) or (user2=%s and user1=%s)",$accno1,$accno2,$accno1,$accno2));
		EventHandler::fireEvent('acceptedrequest',$accno1,$accno2);
		return null;
	}
	
	/**
         * Updates a user relation.
         * 
         * @param int $accno1
         * @param int $accno2
         * @param int $type
         * @return null 
         */
	function updateUserRelation($accno1,$accno2,$type) {
		Database::update('user_relations',array('type'),array($type),sprintf("user1=%s and user2=%s",$accno1,$accno2));
		return null;
	}
	
	/**
         * Fetches information regarding a user relation.
         * 
         * @param int $accno1
         * @param int $accno2
         * @return mixed[] 
         */
	function fetchUserRelationInfo($accno1,$accno2) {
		$set=Database::get('user_relations','status,type',sprintf("(user1=%s and user2=%s) or (user2=%s and user1=%s)",$accno1,$accno2,$accno1,$accno2));
		return $set[0];
	}
	
	/**
	* Fetches relatives of a user.
	* 
	* @param int $accno
	* @return int[]
	*/
	function fetchRelatives($accno) {
		$pre=Database::getPrefix();
		$q1=sprintf("select user1 as acc_no from %suser_relations where user2=%s",$pre,$accno);
		$q2=sprintf("select user2 as acc_no from %suser_relations where user1=%s",$pre,$accno);
		$ptr=Database::query(sprintf("%s union %s",$q1,$q2));
		$relatives=array();
		while($r=mysql_fetch_assoc($ptr)) array_push($relatives,$r['acc_no']);
		return $relatives;
	}
}

?>
