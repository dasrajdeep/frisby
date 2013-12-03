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
 */

 namespace frisby;
 
/**
 * An instance of this class is used to manage events explicitly.
 * 
 * <code>
 * require_once('Event.php');
 * 
 * $event=new Event();
 * </code> 
 * 
 * @package frisby\events
 * @category   PHP
 * @author     Rajdeep Das <das.rajdeep97@gmail.com>
 * @copyright  Copyright 2012 Rajdeep Das
 * @license    http://www.gnu.org/licenses/gpl.txt  The GNU General Public License
 * @version    GIT: v1.0
 * @link       https://github.com/dasrajdeep/frisby
 * @since      Class available since Release 1.0
 */
class Event extends ModuleSupport {

	/**
         * Fires an event explicitly.
         * 
         * The method accepts the name of the event as the first argument.
         * The second is the source identifier and should be a valid user account ID.
         * The third is the destination identifier and is optional.
         * The method fires an event specified by the event name and logs it.
         * The event name must be a registered event name. This engine comes with a set of registered events,
         * which can be viewed by using the 'fetchEventNames' and 'fetchEventCategories' methods.
         * Additional events may be registered by using the 'registerEvent' method.
         * 
         * @see EventRegister::fetchEventNames()
         * @see EventRegister::fetchEventCategories()
         * @see EventRegister::registerEvent()
         * 
         * <code>
         * $src_id=1;
         * $dest_id=2;
         * $event->fireEvent('event_name',$src_id,$dest_id);
         * </code>
         * 
         * @param string $name
         * @param int $src
         * @param int $dest
         * @return null 
         */
	function fireEvent($name,$src,$dest=null) {
		$pre=Database::getPrefix();
                $eid=sprintf("select event_id from %sevents where event_name=%s",$pre,$name);
                $query=sprintf("insert into %sevent_log (event,origin,target) values ((%s),%s,%s)",$pre,$eid,$src,$dest);
		Database::query($query);
		return null;
	}
	
	function updateLiveStatus($accno,$status=1) {
		$pre=Database::getPrefix();
		Database::query(sprintf("update %spoll_log set last_hit=CURRENT_TIMESTAMP,status=%s where acc_no=%s",$pre,$status,$accno));
		return null;
	}
	
	function fetchRecentUsers($accno,$relax=10,$status=1) {
		$users=Database::get('view_poll','acc_no,name,avatar_thumb,avatar_mime',sprintf("status=%s and acc_no<>%s and time_to_sec(timediff(now(),last_hit))<%s",$status,$accno,$relax));
		return $users;
	}
	
	/**
         * Updates an event status.
         * 
         * The method accepts an array of event IDs and a status value.
         * It sets the status of the logged events specified by the IDs to the status value.
         * 
         * <code>
         * $events=array(1,4,3,7);
         * $event->updateStatus($events,1);
         * </code>
         * 
         * @param int[] $events
         * @param int $status
         * @return null 
         */
	function updateEventStatus($events,$status) {
		$ids=implode(',',$events);
		Database::update('event_log',array('status'),array($status),sprintf("log_id in (%s)",$ids));
		return null;
	}
	
	/**
         * Fetches logged events of a specific category.
         * 
         * Event categories include profile,groups,etc. 
         * The method accepts the category name and a timestamp value in 'YYYY-MM-DD HH:MM:SS' format.
         * A status can be optionally specified as an argument to filter by the status of the events.
         * The method fetches all events of the specified category logged since the specified timestamp.
         * 
         * <code>
         * $eventset=$event->fetchEventsByCategory('profile','2012-12-01 00:00:00');
         * </code>
         * 
         * @param string $category
         * @param string $age
		 * @param boolean $verbose
         * @return mixed[] 
         */
	function fetchEventsByCategory($category,$age,$verbose=false) {
		$pre=Database::getPrefix();
		if($verbose) $set=Database::get('view_events','*',sprintf("category='%s' and timestamp>'%s' order by timestamp desc",$category,$age));
		else $set=Database::get('event_log','*',sprintf("event in (select event_id from %sevents where category='%s') and timestamp>='%s' order by timestamp desc",$pre,$category,$age));
		return $set;
	}
	
	/**
         * Fetches logged events related to a particular entity.
         * 
         * The entity referred to here may be a group or user or any other defined entity.
         * The method accepts the IDs of the corresponding source and/or targets of the events,
         * corresponding to the entities.
         * A timestamp is also accepted as a parameter to fetch event logs since a particular time.
         * Timestamp follows the 'YYYY-MM-DD HH:MM:SS' format.
         * 
         * <code>
         * $eventset=$event->fetchEventsByEntity(1,2,'2012-12-01 00:00:00');
         * </code>
         * 
         * @param int $orig
         * @param int $targ
         * @param string $age
         * @return mixed[] 
         */
	function fetchEventsByEntity($orig=null,$targ=null,$age) {
		if(!$orig and !$targ) return array(true,null);
		$filters=array();
		if($orig) array_push($filters,"origin=".$orig);
		if($targ) array_push($filters,"target=".$targ);
		$set=Database::get('event_log','*',sprintf("%s and timestamp>'%s'",implode(' and ',$filters),$age));
		return $set;
	}
}

?>
