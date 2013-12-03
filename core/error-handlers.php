<?php
/**
 * This file contains the error handlers for the engine.
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
 * Default error handler for the system.
 * 
 * @param int $level
 * @param string $message
 * @param string $filename
 * @param int $line
 */
 function defaultHandler($level,$message,$filename,$line) {
	$msg=createMessage(func_get_args());
	EventHandler::fireError('php',$msg);
	postAction($level);
}

/**
 * Customly handles errors originating during system boot.
 * 
 * @param int $level
 * @param string $message
 * @param string $filename
 * @param int $line 
 */
function bootHandler($level,$message,$filename,$line) {
	$msg=createMessage(func_get_args());
	EventHandler::fireError('boot',$msg);
	postAction($level);
}

/**
 * Customly handles errors originating during system boot.
 * 
 * @param int $level
 * @param string $message
 * @param string $filename
 * @param int $line 
 */
function adminHandler($level,$message,$filename,$line) {
	$msg=createMessage(func_get_args());
	EventHandler::fireError('ad',$msg);
	postAction($level);
}

/**
 * Customly handles errors originating during API calls.
 * 
 * @param int $level
 * @param string $message
 * @param string $filename
 * @param int $line 
 */
function apiHandler($level,$message,$filename,$line) {
	$msg=createMessage(func_get_args());
	EventHandler::fireError('api',$msg);
	postAction($level);
}

/**
 * Performs an action based on the error level.
 * 
 * @param int $level 
 */
function postAction($level) {
	if($level<8) {
		die();
	}
}

/**
 * Returns type of error based on level.
 * 
 * @param int $value 
 */
function fetchLevel($value) {
	$errorLevels=array(1=>'FATAL',2=>'WARNING',4=>'PARSE',8=>'NOTICE');
	if($value<10) return $errorLevels[$value];
	else return 'INTERNAL';
}

/**
 * Generates an error message.
 * 
 * @param mixed[] $args
 */
function createMessage($args) {
	$level=fetchLevel($args[0]);
	$message=$args[1];
	$file=$args[2];
	$line=$args[3];
	$error='**'.$level.'** '.$message.' (at file: '.$file.', line '.$line.')';
	return $error;
}
?>
