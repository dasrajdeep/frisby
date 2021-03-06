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

 namespace frisby;
 
/**
 * An instance of this class is used to manage group members.
 * 
 * <code>
 * require_once('GroupMembers.php');
 * 
 * $gm=new GroupMembers();
 * $gm->addMember(memberid,groupid,membershiptype);
 * </code> 
 * 
 * @package frisby\grouping
 */
class GroupMembers extends ModuleSupport {
	
	/**
         * Adds a member to a group.
         * 
         * @param int $accno
         * @param int $grpid
         * @param int $type
         * @return null 
         */
	function addMember($accno,$grpid,$type=0) {
		Database::add('group_members',array('member_id','group_id','type'),array($accno,$grpid,$type));
		EventHandler::fireEvent('joinedgroup',$accno,$grpid);
		return null;
	}
	
	/**
         * Deletes a member from a group.
         * 
         * @param int $accno
         * @param int $grpid
         * @return null 
         */
	function deleteMember($accno,$grpid) {
		Database::remove('group_members',sprintf("member_id=%s and group_id=%s",$accno,$grpid));
		EventHandler::fireEvent('leftgroup',$accno,$grpid);
		return null;
	}
	
        /**
         * Updates privileges for a member of a group.
         * 
         * @param int $accno
         * @param int $grpid
         * @param int $type
         * @return null
         */
	function updateMemberPrivilege($accno,$grpid,$type) {
		Database::update('group_members',array('type'),array($type),sprintf("member_id=%s and group_id=%s",$accno,$grpid));
		if(type==2) EventHandler::fireEvent('becamemoderator',$accno,$grpid);
                return null;
	}
	
	/**
         * Fetches all the members of a specified group.
         * 
         * @param int $grpid
         * @return mixed[] 
         */
	function fetchMembers($grpid) {
		$set=Database::get('group_members','member_id,type,joindate',"group_id=".$grpid);
		return $set;
	}
}

?>
