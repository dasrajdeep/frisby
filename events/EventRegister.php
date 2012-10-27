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
 * An instance of this class is used to register event types.
 * 
 * <code>
 * require_once('EventRegister.php');
 * 
 * $reg=new EventRegister();
 * $reg->registerEvent('event_name','event_category','event_description');
 * </code> 
 */
class EventRegister {
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
         * Registers an event type to be used by the engine
         * 
         * @param string $name
         * @param string $category
         * @param string $desc
         * @return array 
         */
	function registerEvent($name,$category,$desc='') {
		ErrorHandler::reset();
		Database::add('events',array('category','event_name','description'),array($category,$name,$desc));
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		else return array(true,null);
	}
	
	/**
         * Unregisters an event type
         * 
         * @param string $name
         * @return array 
         */
	function unregisterEvent($name) {
		ErrorHandler::reset();
		Database::remove('events',sprintf("event_name='%s'",$name));
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		else return array(true,null);
	}
	
	/**
         * Fetches the names of all event types of a specific category
         * 
         * @param string $category
         * @return array 
         */
	function fetchNames($category) {
		ErrorHandler::reset();
		$set=Database::get('events','event_id,event_name,description',sprintf("category='%s'",$category));
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		else return array(true,$set);
	}
	
	/**
         * Fetches the names of all categories of events
         * 
         * @return array
         */
	function fetchCategories() {
		ErrorHandler::reset();
		$set=Database::get('events','distinct category as cat',false);
		$categories=array();
		foreach($set as $s) array_push($categories,$s['cat']);
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		else return array(true,$categories);
	}
}

?>
