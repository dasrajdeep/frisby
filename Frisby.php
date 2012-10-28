<?php
/**
 * This file contains the bootstrap class for the engine.
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
 * An instance of this class represents a controller for the engine.
 * 
 * <code>
 * require_once('Frisby.php');
 * 
 * $frisby=new Frisby();
 * $resultset=$frisby->call('method_name',arg1,...);
 * </code> 
 * 
 * @package frisby\core
 */
class Frisby {
	/**
         * Contains an object of the Setup class
         * 
         * @var object
         */
	private $setup;
	
	/**
         * Contains an object of the Dispatcher class
         * 
         * @var object
         */
	private $dispatcher;
	
	/**
         * Contains the mappings from the external setup method names to the internal setup methods
         * 
         * @var array
         */
	private $setupmethods=array(
		'setup_installDBSchema'=>'installDBSchema',
		'setup_installDBTriggers'=>'installDBTriggers',
		'setup_installDB'=>'installDB',
		'setup_uninstallDB'=>'uninstallDB'
	);
	
	/**
         * Loads and initializes the classes required by the engine 
         */
	function __construct() {
		//Initializes the dispatcher.
		require_once('Dispatcher.php');
		$this->dispatcher=new Dispatcher();
		
		//Initializes the setup.
		require_once('Setup.php');
		$this->setup=new Setup();
	}
	
	/**
         * The method to invoke methods in the engine related to social networking
         * 
         * @param string $method
         * @return array 
         */
	function call($method) {
		//Runs setup methods.
		if(preg_match('/^(setup_)(.)+/',$method)==1) {
			if(!array_key_exists($method,$this->setupmethods)) {
				ErrorHandler::fire('reg','Invalid Setup Method.');
				return array(false,ErrorHandler::fetchTrace());
			}
			$method=$this->setupmethods[$method];
			$this->setup->$method();
			if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
			else return array(true,null);
		}
		//Runs registry methods.
		else if(preg_match('/^(reg_)(.)+/',$method)==1) {
			$meth=substr($method,4);
			$result=Registry::$meth();
			if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
			else return array(true,$result);
		}
		
		//Runs installer.
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		if(!$this->setup->checkSetup()) $this->setup->run();
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		
		//Dispatch via dispatcher.
		$data=func_get_args();
		$data=array_slice($data,1);
		$result=$this->dispatcher->dispatch($method,$data);
		return $result;
	}
}

?>
