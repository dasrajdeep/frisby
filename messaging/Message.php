<?php
/**
 * This file contains the Message class.
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
 * An instance of this class is used to create and send messages.
 * 
 * <code>
 * require_once('.php');
 * 
 * $msg=new Message();
 * $msg->sendMessage(sender_id,receiver_id,'message_text');
 * </code> 
 */
class Message {
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
         * Sends a message
         * 
         * @param int $sender
         * @param int $receiver
         * @param string $msg
         * @return array 
         */
	function sendMessage($sender,$receiver,$msg) {
		ErrorHandler::reset();
		Database::add('messages',array('sender','receiver','textdata','status'),array($sender,$receiver,$msg,1));
		EventHandler::fire('sentmessage',$sender,$receiver);
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		else return array(true,null);
	}
	
	/**
         * Saves a message as a draft
         * 
         * @param int $sender
         * @param int $receiver
         * @param string $msg
         * @return array 
         */
	function saveDraft($sender,$receiver,$msg) {
		ErrorHandler::reset();
		Database::add('messages',array('sender','receiver','textdata','status'),array($sender,$receiver,$msg,0));
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		else return array(true,null);
	}
	
	/**
         * Updates a stored draft
         * 
         * @param int $msgid
         * @param string $msg
         * @return array 
         */
	function editDraft($msgid,$msg) {
		ErrorHandler::reset();
		Database::update('messages',array('textdata'),array($msg),"msg_id=".$msgid);
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		else return array(true,null);
	}
	
	/**
         * Sends a stored draft
         * 
         * @param int $msgid
         * @return array 
         */
	function sendDraft($msgid) {
		ErrorHandler::reset();
		Database::update('messages',array('status'),array(1),"msg_id=".$msgid);
		$set=Database::get('messages','sender,receiver',"msg_id=".$msgid);
		EventHandler::fire('sentmessage',$set[0]['sender'],$set[0]['receiver']);
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		else return array(true,null);
	}
}

?>
