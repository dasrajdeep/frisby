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
class UserRelations {
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
         * Creates a new user relations
         * 
         * @param int $accno1
         * @param int $accno2
         * @param int $type
         * @return array 
         */
	function createRelation($accno1,$accno2,$type=0) {
		ErrorHandler::reset();
		Database::add('user_relations',array('user1','user2','type','status'),array($accno1,$accno2,$type,0));
		EventHandler::fire('sentfriendrequest',$accno1,$accno2);
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		else return array(true,null);
	}
	
	/**
         * Updates a user relation by changing its status to accepted
         * 
         * @param int $accno1
         * @param int $accno2
         * @return array 
         */
	function confirmRelation($accno1,$accno2) {
		ErrorHandler::reset();
		Database::update('user_relations',array('status'),array(1),sprintf("(user1=%s and user2=%s) or (user2=%s and user1=%s)",$accno1,$accno2,$accno1,$accno2));
		EventHandler::fire('acceptedrequest',$accno1,$accno2);
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		else return array(true,null);
	}
	
	/**
         * Updates a user relation
         * 
         * @param int $accno1
         * @param int $accno2
         * @param int $type
         * @return array 
         */
	function updateRelation($accno1,$accno2,$type) {
		ErrorHandler::reset();
		Database::update('user_relations',array('type'),array($type),sprintf("user1=%s and user2=%s",$accno1,$accno2));
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		else return array(true,null);
	}
	
	/**
         * Fetches information regarding a user relation
         * 
         * @param int $accno1
         * @param int $accno2
         * @return array 
         */
	function fetchRelationInfo($accno1,$accno2) {
		ErrorHandler::reset();
		$set=Database::get('user_relations','status,type',sprintf("(user1=%s and user2=%s) or (user2=%s and user1=%s)",$accno1,$accno2,$accno1,$accno2));
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		else return array(true,$set[0]);
	}
}

?>
