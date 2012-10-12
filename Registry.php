//This section registers the modules of the engine.

//This section contains the names of the methods of the engine accesible by the application.

//Load routes on demand.
<?php

class Registry {
	//Contains the mappings for all the methods that are accessible.
	private static $map=array();
	
	//Initializes the registry.
	static function init() {
		require_once('config/mappings.inc');
		self::$map=$map;
	}
	
	static function read($method) {
		return self::$map[$method];
	}
}

?>