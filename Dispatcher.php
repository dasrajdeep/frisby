<?php
/**
 * This file contains the dispatcher for the engine.
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
 * An instance of this class represents a dispatcher for the methods registered in the engine.
 * 
 * <code>
 * require_once('Dispatcher.php');
 * 
 * $dispatcher=new Dispatcher();
 * $data=array(var1,...);
 * $resultset=$dispatcher->dispatch('method_name',$data);
 * </code> 
 * 
 * @package frisby\core
 */
class Dispatcher {
	
	/**
         * Performs housekeeping for the engine 
         */
	static function cleanup() {
		Database::disconnect();
		Logger::shutdown();
	}
	
	/**
         * Loads and/or initializes the necessary classes and registers a shutdown function 
         */
	function __construct() {
		//Dispatcher first initializes the logger.
		require_once('Logger.php');
		Logger::init();
		
		//Dispatcher initializes the error handler.
		require_once('ErrorHandler.php');

		//Dispatcher initializes the database.
		require_once('Database.php');
		Database::connect();

		//Dispatcher initializes the registry.
		require_once('Registry.php');
		Registry::init();
		
		//Dispatcher initializes event handler.
		require_once('EventHandler.php');
		
		//Registers a function to be executed when the process completes.
		register_shutdown_function('Dispatcher::cleanup');
	}
	
	/**
         * Invokes a method supplied as argument and returns the data returned by the invoked method
         * 
         * @param string $method
         * @param array $data
         * @return array 
         */
	function dispatch($method,$data) {
		//Consults registry to obtain the appropriate route.
		$route=Registry::read($method);
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		if(!Registry::validateArguments($route[1],$data)) {
			ErrorHandler::fire('int','Invalid number/type of arguments.');
			return array(false,ErrorHandler::fetchTrace());
		}
		
		//Invokes the requested method.
		require_once('Controller.php');
		Registry::load($route[0]);
		$controllerName=$route[0].'Controller';
		$control=new $controllerName();
		
		//Changes the directory.
		chdir(Registry::getLocation($route[0]));
		$result=$control->invoke($route[1],$data);
		chdir('../');
		return $result;
	}
	
}

?>
