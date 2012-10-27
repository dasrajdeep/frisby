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
 * This class is used to access the registry of the engine and load modules.
 * 
 * <code>
 * require_once('Registry.php');
 * 
 * $map=Registry::read('method_name');
 * Registry::load($map[0]);
 * </code> 
 */
class Registry {
	/**
         * Contains the names of the modules used by the engine
         * 
         * @var array 
         */
	private static $modules=array('events','grouping','messaging','profiling','pubsub','search','user-relations');
	
	/**
         * Contains the mappings from the external method names to the internal path
         * 
         * @var array
         */
	private static $map=array();
	
	/**
         * Contains the routes for the internal methods
         * 
         * @var array
         */
	private static $modroute=array();
	
	/**
         * Contains the method signatures
         * 
         * @var array
         */
	private static $sig=array();
	
	/**
         * Loads the mappings and signatures from an external file and also checks for integrity
         */
	static function init() {
		require_once('config/mappings.inc');
		self::$map=$map;
		self::$modroute=$routes;
		require_once('config/methodargs.inc');
		self::$sig=$sig;
		$mod=self::scanModules();
		$loaded=array();
		foreach(self::$map as $m) array_push($loaded,$m[1]);
		foreach($mod as $m) if(!in_array($m,$loaded)) ErrorHandler::fire('int',sprintf('Method "%s" not registered.',$m));
	}
	
	/**
         * Fetches the route associated with an external method name
         * 
         * @param string $method
         * @return array 
         */
	static function read($method) {
		$route=@self::$map[$method];
		if($route==null) ErrorHandler::fire('reg','Method does not exist.');
		return $route;
	}
	
	/**
         * Loads a module controller into the engine
         * 
         * @param string $module 
         */
	static function load($module) {
		require_once(self::$modroute[$module].'/controller.php');
	}
	
	/**
         * Fetches the location of a module relative to the base directory
         * 
         * @param string $module
         * @return string 
         */
	static function getLocation($module) {
		return self::$modroute[$module];
	}
	
	/**
         * Validates an argument list passed to a method against its signature
         * 
         * @param string $method
         * @param array $list
         * @return boolean 
         */
	static function validateArguments($method,$list) {
		if(!array_key_exists($method,self::$sig)) return false;
		$ms=self::$sig[$method];
		if(count($list)<$ms[0] || count($list)>$ms[1]) return false;
		for($i=0;$i<count($list);$i++) {
			if($ms[2][$i]==0 && !is_null($list[$i]) && !is_numeric($list[$i])) return false;
			if($ms[2][$i]==1 && !is_null($list[$i]) && !is_string($list[$i])) return false;
			if($ms[2][$i]==2 && !is_array($list[$i])) return false;
		}
		return true;
	}
	
	/**
         * Fetches the external names of the methods that are invokable by the user
         * 
         * @return array
         */
	static function getMethodNames() {
		return array_keys(self::$map);
	}
	
	/**
         * Scans the class files of the engine to get a list of the defined methods
         * 
         * @return array 
         */
	private static function scanModules() {
		$methods=array();
		foreach(self::$modules as $m) {
			$list=scandir($m);
			$classes=array();
			foreach($list as $l) if(preg_match('/^[A-Z][a-zA-Z]*[.]php*$/',$l)==1) array_push($classes,$l);
			foreach($classes as $c) {
				require_once($m.'/'.$c);
				$meth=get_class_methods(substr($c,0,-4));
				foreach($meth as $x) if($x!='__construct') array_push($methods,$x);
			}
		}
		return $methods;
	}
}

?>
