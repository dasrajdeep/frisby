<?php
/**
 * This file contains the Group class.
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
 * An instance of this class is used to manage groups in the social network.
 * 
 * <code>
 * require_once('Group.php');
 * 
 * $grp=new Group();
 * $grp->createGroup(creatorid,'group_name','group_description',grouptype);
 * </code> 
 * 
 * @package frisby\grouping
 */
class Group extends ModuleSupport {
	
	/**
         * Creates a new group.
         * 
         * @param int $creator
         * @param string $name
         * @param string $desc
         * @param int $type
         * @return null 
         */
	function createGroup($creator,$name,$desc,$type=0) {
		ErrorHandler::reset();
		$ref=Database::add('groups',array('name','description','type'),array($name,$desc,$type));
		if($ref) $ref=mysql_insert_id();
		Database::add('group_members',array('member_id','group_id','type'),array($creator,$ref,1));
		EventHandler::fire('creatednewgroup',$creator,$ref);
		return null;
	}
	
	/**
         * Deletes a group.
         * 
         * @param int $grpid
         * @return null 
         */
	function deleteGroup($grpid) {
		ErrorHandler::reset();
		Database::remove('groups',"group_id=".$grpid);
		Database::remove('group_members',"group_id=".$grpid);
		return null;
	}
	
	/**
         * Updates information for a group.
         * 
         * @param int $grpid
         * @param array $data
         * @return null 
         */
	function updateGroup($grpid,$data) {
		ErrorHandler::reset();
		$keys=array_keys($data);
		$values=array();
		foreach($keys as $k) array_push($values,$data[$k]);
		Database::update('groups',$keys,$values,"group_id=".$grpid);
		return null;
	}

	/**
         * Fetches all information regarding a specific group.
         * 
         * @param int $grpid
         * @return mixed[] 
         */
	function fetchGroup($grpid) {
		ErrorHandler::reset();
		$set=Database::get('groups','*',"group_id=".$grpid);
		return $set[0];	
	}
}

?>
