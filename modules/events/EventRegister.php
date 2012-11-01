<?php
/**
 * This file contains the EventRegister class.
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

/**
 * An instance of this class is used to register event types.
 * 
 * <code>
 * require_once('EventRegister.php');
 * 
 * $reg=new EventRegister();
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
class EventRegister extends ModuleSupport {
	
	/**
         * Registers an event type.
         * 
         * Registers an event type to be used by the engine identified by a name specified in the first argument. 
         * The event type can then be used to explicity fire events of that type using the method 'fireEvent'.
         * The event type must be assigned a category when registering as the second argument.
         * A short description of the event may be provided.
         * 
         * @see Event::fireEvent()
         * 
         * <code>
         * $reg->registerEvent('event_name','event_category','event_description');
         * </code>
         * 
         * @param string $name
         * @param string $category
         * @param string $desc
         * @return null 
         */
	function registerEvent($name,$category,$desc='') {
		Database::add('events',array('category','event_name','description'),array($category,$name,$desc));
		return null;
	}
	
	/**
         * Unregisters an event type.
         * 
         * Removes an event type from the system. 
         * This is specified by the event name which is the only argument accepted by the method.
         * 
         * <code>
         * $reg->unregisterEvent('event_name');
         * </code>
         * 
         * @param string $name
         * @return null 
         */
	function unregisterEvent($name) {
		Database::remove('events',sprintf("event_name='%s'",$name));
		return null;
	}
	
	/**
         * Fetches event types by category.
         * 
         * Fetches the names of all event types of a specified category.
         * 
         * <code>
         * $names=$reg->fetchEventNames('category');
         * </code>
         * 
         * @param string $category
         * @return mixed[] 
         */
	function fetchEventNames($category) {
		$set=Database::get('events','event_id,event_name,description',sprintf("category='%s'",$category));
		return $set;
	}
	
	/**
         * Fetches event categories.
         * 
         * Fetches the names of all categories of events registered on the system.
         * 
         * <code>
         * $cats=$reg->fetchEventCategories();
         * </code>
         * 
         * @return string[]
         */
	function fetchEventCategories() {
		$set=Database::get('events','distinct category as cat',false);
		$categories=array();
		foreach($set as $s) array_push($categories,$s['cat']);
		return $categories;
	}
}

?>
