<?php
/**
 * This file contains the event logger for the engine.
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
 * This class is used to log engine related events to a log file.
 * 
 * <code>
 * require_once('Logger.php');
 * 
 * Logger::dump('event_type','event_description');
 * </code>
 */
class Logger {
	/**
         * Contains a handler to the log file
         * 
         * @var object
         */
	private static $file;
	
	/**
         * Contains the mappings from the event mnemonics to the event names
         * 
         * @var array
         */
	static $logtype=array(
		'db'=>'DATABASE',
		'reg'=>'REGISTRY',
		'evt'=>'EVENTS',
		'int'=>'INTEGRITY'
	);
	
	/**
         * Creates or opens the log file for writing 
         */
	public static function init() {
		self::$file=file_exists('data/log.txt');
		if(!self::$file) self::$file=fopen('data/log.txt','w');
		else self::$file=fopen('data/log.txt','a+');
		$permitted=@chmod('data/log.txt',0777);
	}
	
	/**
         * Dumps a log event to the log file
         * 
         * @param string $type
         * @param string $message 
         */
	public static function dump($type,$message) {
		fwrite(self::$file,'['.time().']'.self::$logtype[$type].':'.$message.'\n');
	}
	
	/**
         * Closes the file handler 
         */
	public static function shutdown() {
		fclose(self::$file);
	}
}

?>
