<?php
/**
 * This file contains the error-handler for the engine.
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
 * This class is used to manage errors that are triggered within the engine.
 * 
 * <code>
 * require_once('ErrorHandler.php');
 * 
 * ErrorHandler::fire('error_type','error_message');
 * $trace=ErrorHandler::fetchTrace();
 * </code> 
 * 
 * @package frisby\core
 * @category   PHP
 * @author     Rajdeep Das <das.rajdeep97@gmail.com>
 * @copyright  Copyright 2012 Rajdeep Das
 * @license    http://www.gnu.org/licenses/gpl.txt  The GNU General Public License
 * @version    GIT: v1.0
 * @link       https://github.com/dasrajdeep/frisby
 * @since      Class available since Release 1.0
 */
class ErrorHandler {
	/**
         * Contains the last trace of errors fired
         * 
         * @var array 
         */
	private static $tracelist=array();
	
	/**
         * Contains a flag to check whether any error event was fired
         * 
         * @var boolean 
         */
	private static $error=false;
	
	/**
         * Triggers an error event
         * 
         * @param string $type
         * @param string $message 
         */
	static function fire($type,$message) {
		self::$error=true;
		array_push(self::$tracelist,array($type,$message));
		Logger::dump($type,$message);
	}
	
	/**
         * Fetches the last recorded trace of the fired error events
         * 
         * @return array 
         */
	static function fetchTrace() {
                for($i=0;$i<count(self::$tracelist);$i++) self::$tracelist[$i][0]=Logger::event(self::$tracelist[$i][0]);
		return self::$tracelist;
	}
	
	/**
         * Fetches a flag indicating the occurence of any error
         * 
         * @return boolean 
         */
	static function hasErrors() {
		return self::$error;
	}
	
	/**
         * Resets the error flag and removes all errors from the trace list 
         */
	static function reset() {
		self::$error=false;
		array_splice(self::$tracelist,0);
	}
}
?>
