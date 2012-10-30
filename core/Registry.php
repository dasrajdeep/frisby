<?php
/**
 * This file contains the registry which contains the method mappings and signatures.
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
 * This class is used to access the registry of the engine and load modules.
 * 
 * <code>
 * require_once('Registry.php');
 * 
 * Registry::init();
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
class Registry {
	
	private static $modules;
	
	/**
         * Loads the mappings and signatures from an external file
         */
	static function init() {
		
		//Loads information regarding the modules and their locations.
		require_once('../config/modules.inc');
		self::$modules=$modules;
	}
	
	/**
         * Fetches the route associated with an external method name
         * 
         * @param string $method
         * @return array 
         */
        
    static function read($method) {
		$route=Database::get('registry','module,classname',sprintf("method='%s'",$method));
		if(count($route)==0) {
			ErrorHandler::fire('val','No such method exists.');
			return null;
		}
		return $route[0];
	}  
      
	static function location($module) {
		if(array_key_exists($module,self::$modules)) return self::$modules[$module];
		ErrorHandler::fire('int','Module does not exist.');
		return null;
	}
	
	/**
         * Fetches the names of the API methods.
         * 
         * @return array
         */
	static function getMethodNames() {
		$rs=Database::get('registry','method',false);
		$names=array();
		foreach($rs as $r) array_push($names,$r['method']);
		return $names;
	}
	
	static function getModuleNames() {
		return array_keys(self::$modules);
	}
}

?>
