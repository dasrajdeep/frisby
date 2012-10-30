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
 * </code> 
 * 
 * @package frisby\core
 * @category   PHP
 * @author     Rajdeep Das <das.rajdeep97@gmail.com>
 * @copyright  Copyright 2012 Rajdeep Das
 * @license    http://www.gnu.org/licenses/gpl.txt  The GNU General Public License
 * @version    GIT: v2.0
 * @link       https://github.com/dasrajdeep/frisby
 * @since      Class available since Release 1.0
 */
class Admin {
	
	private $methods=array();
	
	function __construct() {
		$methods=get_class_methods($this);
		foreach($methods as $m) if($m!='__construct' && $m!='invoke') array_push($this->methods,$m);
	}
	
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
	
	function fetchLog() {
		return Logger::read();
	}
	
	function checkSetup() {
		require_once('Setup.php');
		$setup=new Setup();
		$condition=$setup->checkSetup();
		return $condition;
	}
	
	function cleanInstall() {
		require_once('Setup.php');
		$setup=new Setup();
		$setup->uninstall();
		$setup->installAll();
	}
	
	function install() {
		require_once('Setup.php');
		$setup=new Setup();
		$setup->installAll();
	}
	
	function uninstall() {
		require_once('Setup.php');
		$setup=new Setup();
		$setup->uninstall();
	}
	
	function getAPIMethods() {
		return Registry::getMethodNames();
	}
	
	function getAdminMethods() {
		return $this->methods;
	}
	
	function updateModules() {
		require_once('Setup.php');
		$setup=new Setup();
		$setup->installRegistry();
	}
}

?>
