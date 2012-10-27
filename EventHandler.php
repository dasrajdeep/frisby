<?php
/**
 * This file contains the event handler for implicit events registered in the engine.
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
 * This class can be used to fire an implicit event from within a module,
 * 
 * <code>
 * require_once('EventHandler.php');
 * 
 * EventHandler::fire('event_name',sourceid,destinationid);
 * </code> 
 */
class EventHandler {
	
	/**
         * Fires an event specified by a name and the participants
         * 
         * @param string $event
         * @param int $source
         * @param int $target 
         */
	static function fire($event,$source,$target=null) {
		$pre=Database::getPrefix();
		$values=sprintf("(select event_id from %sevents where event_name='%s'),%s,%s",$pre,$event,$source,$target);
		Database::query("insert into %sevent_log (event,source,target) values (%s)",$pre,$values);
	}
}

?>
