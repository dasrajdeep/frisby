<?php

class Registry {
	//Contains the names of all the modules.
	private static $modules=array('events','grouping','messaging','profiling','pubsub','search','user-relations');
	
	//Contains the mappings for all the methods that are accessible.
	private static $map=array();
	
	//Contains location information regarding the modules.
	private static $modroute=array();
	
	//Contains the method signatures.
	private static $sig=array();
	
	//Initializes the registry.
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
	
	//Reads a specific mapping from the registry.
	static function read($method) {
		$route=@self::$map[$method];
		if($route==null) ErrorHandler::fire('reg','Method does not exist.');
		return $route;
	}
	
	//Loads a specific module on demand.
	static function load($module) {
		require_once(self::$modroute[$module].'/controller.php');
	}
	
	//Fetches the module location.
	static function getLocation($module) {
		return self::$modroute[$module];
	}
	
	//Validates argument list for a method.
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
	
	//Scans all the modules to find their public methods.
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
