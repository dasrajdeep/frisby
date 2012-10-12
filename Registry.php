<?php

class Registry {
	//Contains the mappings for all the methods that are accessible.
	private static $map=array();
	
	//Contains location information regarding the modules.
	private static $modroute=array();
	
	//Initializes the registry.
	static function init() {
		require_once('config/mappings.inc');
		self::$map=$map;
		self::$modroute=$routes;
	}
	
	//Reads a specific mapping from the registry.
	static function read($method) {
		return self::$map[$method];
	}
	
	//Loads a specific module on demand.
	static function load($module) {
		require_once(self::$modroute[$module]);
	}
}

?>