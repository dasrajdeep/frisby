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
 */	

/**
 * This class is used to log engine related events to a log file.
 * 
 * <code>
 * require_once('Logger.php');
 * 
 * Logger::dump('event_type','event_description');
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
class Logger {
	/**
         * Contains a handler to the log file.
         * 
         * @var object
         */
	private static $file;
	
        /**
         * Contains the filename of the log file.
         * 
         * @var string 
         */
	private static $filename='../data/log.txt';
	
	/**
         * Contains the mappings from the event mnemonics to the event names.
         * 
         * @var mixed[]
         */
        private static $sysEvents=array(
            'db'=>'DATABASE',
            'php'=>'PHP',
            'val'=>'VALIDATION',
            'set'=>'SETUP',
            'arg'=>'ARGUMENTS',
            'int'=>'INTEGRITY',
			'boot'=>'BOOT',
			'ad'=>'ADMIN',
			'api'=>'API'
        );
	
	/**
         * Creates or opens the log file for writing. 
         */
	public static function init() {
		self::$file=file_exists(self::$filename);
		if(!self::$file) self::$file=fopen(self::$filename,'w');
		else self::$file=fopen(self::$filename,'a+');
		chmod(self::$filename,0777);
	}
	
	/**
         * Dumps a log event to the log file.
         * 
         * @param string $type
         * @param string $message 
         */
	public static function dump($type,$message) {
                $event=@self::$sysEvents[$type];
		fwrite(self::$file,'['.time().']'.$event.':'.$message.'\n');
	}
	
        /**
         * Fetches the log.
         * 
         * @return string 
         */
	public static function read() {
		$size=filesize(self::$filename);
		if($size==0) $log='Log empty.';
		else $log=fread(self::$file,$size);
		return $log;
	}
	
	/**
         * Clears the log. 
         */
	public static function clear() {
		ftruncate(self::$file,0);
	}
        
        /**
         * Gets the event name corresponding to a mnemonic.
         * 
         * @param string $mnemonic
         * @return string|null 
         */
        public static function event($mnemonic) {
            if(array_key_exists($mnemonic, self::$sysEvents)) return self::$sysEvents[$mnemonic];
            else return null;
        }

        /**
         * Closes the file handler. 
         */
	public static function shutdown() {
		fclose(self::$file);
	}
}

?>
