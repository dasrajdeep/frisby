<?php
/**
 * This file contains the admin for the engine.
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
 * An instance of this class represents a dispatcher for the Administration methods registered in the engine.
 * 
 * <code>
 * require_once('Admin.php');
 * 
 * $admin=new Admin();
 * </code> 
 * 
 * @package frisby\core
 * @category   PHP
 * @author     Rajdeep Das <das.rajdeep97@gmail.com>
 * @copyright  Copyright 2012 Rajdeep Das
 * @license    http://www.gnu.org/licenses/gpl.txt  The GNU General Public License
 * @version    GIT: v2.0
 * @link       https://github.com/dasrajdeep/frisby
 * @since      Class available since Release 2.0
 */
class Admin {
	/**
         * Contains the callable methods of the Admin class.
         * 
         * @var string[] 
         */
	private $methods=array();
	
        /**
         * Constructs the array of admin methods. 
         */
	function __construct() {
		$methods=get_class_methods($this);
		foreach($methods as $m) if($m!='__construct' && $m!='invoke') array_push($this->methods,$m);
	}
	
        /**
         * Invokes an administrative method.
         * 
         * @param string $method
         * @param mixed[] $data
         * @return mixed[] 
         */
	public function invoke($method,$data) {
		if(!in_array($method,$this->methods)) {
			ErrorHandler::fire('val','No such method exists.');
			return null;
		}
                try {
                    $result=call_user_func_array(array($this,$method),$data);
                } catch(Exception $e) {
                    ErrorHandler::fire('arg', 'Invalid argument(s) supplied.');
                    $result=null;
                }
		return $result;
	}
	
        /**
         * Fetches the system event log.
         * 
         * @return string 
         */
	function fetchLog() {
		return Logger::read();
	}
	
        /**
         * Checks for integrity of the engine setup.
         * 
         * @return boolean 
         */
	function checkSetup() {
		require_once('Setup.php');
		$setup=new Setup();
		$condition=$setup->checkSetup();
		return $condition;
	}
	
        /**
         * Cleans and reinstalls the software. 
         */
	function cleanInstall() {
		require_once('Setup.php');
		$setup=new Setup();
		$setup->uninstall();
		$setup->installAll();
	}
	
        /**
         * Installs the software. 
         */
	function install() {
		require_once('Setup.php');
		$setup=new Setup();
		$setup->installAll();
	}
	
        /**
         * Uninstalls the software. 
         */
	function uninstall() {
		require_once('Setup.php');
		$setup=new Setup();
		$setup->uninstall();
	}
	
        /**
         * Fetches the registered API methods.
         * 
         * @return string[] 
         */
	function getAPIMethods() {
		return Registry::getMethodNames();
	}
	
        /**
         * Fetches the registered Admin methods.
         * 
         * @return string[] 
         */
	function getAdminMethods() {
		return $this->methods;
	}
	
        /**
         * Scans and updates the API modules. 
         */
	function updateModules() {
		require_once('Setup.php');
		$setup=new Setup();
		$setup->installRegistry();
	}
}

?>
