<?php
/**
 * This file contains the Event class.
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
 * An instance of this class is used to manage events explicitly.
 * 
 * <code>
 * require_once('Event.php');
 * 
 * $event=new Event();
 * $event->fireEvent('event_name',sourceid,destinationid);
 * </code> 
 */
class Event {
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
         * Fires an event explicitly
         * 
         * @param string $name
         * @param int $src
         * @param int $dest
         * @return array 
         */
	function fireEvent($name,$src,$dest=null) {
		ErrorHandler::reset();
		$pre=Database::getPrefix();
		Database::query(sprintf("insert into %sevent_log (event,origin,target) values ((select event_id from %sevents where event_name=%s),%s,%s)",$pre,$pre,$name,$src,$dest));
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		else return array(true,null);
	}
	
	/**
         * Updates an event status
         * 
         * @param array $events
         * @param int $status
         * @return array 
         */
	function updateStatus($events,$status) {
		ErrorHandler::reset();
		$ids=implode(',',$events);
		Database::update('event_log',array('status'),array($status),sprintf("log_id in (%s)",$ids));
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		else return array(true,null);
	}
	
	/**
         * Fetches logged events of a specific category
         * 
         * @param string $category
         * @param string $age
         * @param int $status
         * @return array 
         */
	function fetchEventsByCategory($category,$age,$status=null) {
		ErrorHandler::reset();
		$pre=Database::getPrefix();
		if($status) $set=Database::get('event_log','*',sprintf("event in (select event_id from %sevents where category='%s') and timestamp>='%s' and status=%s",$pre,$category,$age,$status));
		else $set=Database::get('event_log','*',sprintf("event in (select event_id from %sevents where category='%s') and timestamp>='%s'",$pre,$category,$age));
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		else return array(true,$set);
	}
	
	/**
         * Fetches logged events related to a particular entity
         * 
         * @param int $orig
         * @param int $targ
         * @param string $age
         * @return array 
         */
	function fetchEventsByEntity($orig=null,$targ=null,$age) {
		ErrorHandler::reset();
		if(!$orig and !$targ) return array(true,null);
		$filters=array();
		if($orig) array_push($filters,"origin=".$orig);
		if($targ) array_push($filters,"target=".$targ);
		$set=Database::get('event_log','*',sprintf("%s and timestamp>='%s'",implode(' and ',$filters),$age));
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		else return array(true,$set);
	}
}

?>
