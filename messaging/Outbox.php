<?php
/**
 * This file contains the Outbox class.
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
 * An instance of this class is used to manage outboxes.
 * 
 * <code>
 * require_once('.php');
 * 
 * $outbox=new Outbox();
 * $resultset=$outbox->fetchOutbox(userid);
 * </code> 
 * 
 * @package frisby\messaging
 */
class Outbox extends ModuleSupport {
	
	/**
         * Fetches the outbox of a user
         * 
         * @param int $accno
         * @return array 
         */
	function fetchOutbox($accno) {
		ErrorHandler::reset();
		$set=Database::get('messages','*',"status in (0,1,3,9,11) and sender=".$accno);
		return $set;
	}
	
	/**
         * Deletes messages from an outbox
         * 
         * @param array $idlist
         * @param int $accno
         * @return array 
         */
	function deleteOutboxMessages($idlist,$accno) {
		ErrorHandler::reset();
		$set=implode(',',$idlist);
		if(count($idlist)>0) Database::query(sprintf("update %smessages set status=status+4 where status in (0,1,3,9,11) and msg_id in (%s)",Database::getPrefix(),$set));
		else Database::query(sprintf("update %smessages set status=status+4 where status in (0,1,3,9,11) and sender=%s",Database::getPrefix(),$accno));
		Database::remove('messages',"status in (4,13,15)");
		return null;
	}
}

?>
