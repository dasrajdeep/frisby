<?php
/**
 * This file contains the Inbox class.
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
 * An instance of this class is used to manage message inboxes.
 * 
 * <code>
 * require_once('.php');
 * 
 * $inbox=new Inbox();
 * $resultset=$inbox->fetchInbox(userid);
 * </code> 
 * 
 * @package frisby\messaging
 */
class Inbox extends ModuleSupport {
	
	/**
         * Fetches the entire inbox.
         * 
         * @param int $accno
         * @return mixed[] 
         */
	function fetchInbox($accno) {
		$set=Database::get('messages','*',"status in (1,3,5,7) and receiver=".$accno);
		return $set;
	}
	
	/**
         * Fetches unread messages from the inbox.
         * 
         * @param int $accno
         * @return mixed[] 
         */
	function fetchUnread($accno) {
		$set=Database::get('messages','*',"status in (1,5) and receiver=".$accno);
		return $set;
	}
	
	/**
         * Marks messages in the inbox as read.
         * 
         * @param int[] $msgids
         * @return null 
         */
	function markRead($msgids) {
		$set=implode(',',$msgids);
		Database::query(sprintf("update %smessages set status=status+2 where msg_id in (%s)",Database::getPrefix(),$set));
		return null;
	}
	
	/**
         * Deletes messages from the inbox.
         * 
         * @param int[] $idlist
         * @param int $accno
         * @return null 
         */
	function deleteInboxMessages($idlist,$accno) {
		$set=implode(',',$idlist);
		if(count($idlist)>0) Database::query(sprintf("update %smessages set status=status+8 where status in (1,3,5,7) and msg_id in (%s)",Database::getPrefix(),$set));
		else Database::query(sprintf("update %smessages set status=status+8 where status in (1,3,5,7) and receiver=%s",Database::getPrefix(),$accno));
		Database::remove('messages',"status in (13,15)");
		return null;
	}
}

?>
