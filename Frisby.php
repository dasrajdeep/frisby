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
 */

/**
 * An instance of this class represents a controller for the engine.
 * 
 * <code>
 * require_once('Frisby.php');
 * 
 * $frisby=new Frisby();
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
class Frisby {	
	
	function __construct() {
		//Boots up the engine and moves to core directory.
		chdir('core');
		require_once('Bootstrap.php');
		chdir('..');
	}
	
	function call($method) {
		
		chdir('core');
		
		$data=func_get_args();
		$data=array_slice($data,1);
		
		ErrorHandler::reset();
		
		if(preg_match('/^(admin_)(.)+/',$method)==1) {
			$method=substr($method,6);
			require_once('Admin.php');
			$admin=new Admin();
			$result=$admin->invoke($method,$data);
		}
		else {
			require_once('Dispatcher.php');
			$api=new Dispatcher();
			$result=$api->dispatch($method,$data);
		}
		
		chdir('..');
		
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		else return array(true,$result);
	}
}

?>
