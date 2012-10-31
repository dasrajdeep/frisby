<?php
/**
 * This file contains the boostrap loader for the engine.
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

ini_set('display_errors', false);

require_once('Logger.php');
require_once('ErrorHandler.php');
require_once('Database.php');
require_once('Registry.php');
require_once('ModuleSupport.php');

Logger::init();
Database::connect();
Registry::init();

set_error_handler('errorHandler');
register_shutdown_function('shutdown');

/**
 * Performs housekeeping at script termination. 
 */
function shutdown() {
	Database::disconnect();
	Logger::shutdown();
}

/**
 * Customly handles errors originating from the system.
 * 
 * @param int $level
 * @param string $message
 * @param string $filename
 * @param int $line
 * @throws Exception 
 */
function errorHandler($level,$message,$filename,$line) {
        $levels=array(1=>'FATAL',2=>'WARNING',4=>'PARSE',8=>'NOTICE');
        if($level<10) $level=$levels[$level];
        $error='**'.$level.'** '.$message.' (at file: '.$filename.', line '.$line.')';
        ErrorHandler::fire('php', $error);
	throw new Exception('Frisby Exception');
	die();
}

?>
