<?php
/**
 * This file contains the GroupMembers class.
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
 * An instance of this class is used to manage group members.
 * 
 * <code>
 * require_once('GroupMembers.php');
 * 
 * $gm=new GroupMembers();
 * $gm->addMember(memberid,groupid,membershiptype);
 * </code> 
 */
class GroupMembers {
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
         * Adds a member to a specific group
         * 
         * @param int $accno
         * @param int $grpid
         * @param int $type
         * @return array 
         */
	function addMember($accno,$grpid,$type=0) {
		ErrorHandler::reset();
		Database::add('group_members',array('member_id','group_id','type'),array($accno,$grpid,$type));
		EventHandler::fire('joinedgroup',$accno,$grpid);
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		else return array(true,null);
	}
	
	/**
         * Deletes a member from a group
         * 
         * @param int $accno
         * @param int $grpid
         * @return array 
         */
	function deleteMember($accno,$grpid) {
		ErrorHandler::reset();
		Database::remove('group_members',sprintf("member_id=%s and group_id=%s",$accno,$grpid));
		EventHandler::fire('leftgroup',$accno,$grpid);
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		else return array(true,null);
	}
	
        /**
         * Updates privileges for a member of a group
         * 
         * @param int $accno
         * @param int $grpid
         * @param int $type
         * @return array 
         */
	function updatePrivilege($accno,$grpid,$type) {
		ErrorHandler::reset();
		Database::update('group_members',array('type'),array($type),sprintf("member_id=%s and group_id=%s",$accno,$grpid));
		if(type==2) EventHandler::fire('becamemoderator',$accno,$grpid);
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		else return array(true,null);
	}
	
	/**
         * Fetches all the members of a specific group
         * 
         * @param int $grpid
         * @return array 
         */
	function fetchMembers($grpid) {
		ErrorHandler::reset();
		$set=Database::get('group_members','member_id,type,joindate',"group_id=".$grpid);
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		else return array(true,$set);
	}
}

?>
