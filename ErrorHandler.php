<?php

class ErrorHandler {
	//An array of error traces.
	private static $tracelist=array();
	
	//A flag to check if any error(s) occurred.
	private static $error=false;
	
	//An array holding the types of error messages.
	static $errtype=array(
		'db'=>'DATABASE'
	);
	
	//Adds an error trace to the error stack.
	static function fire($type,$message) {
		self::$error=true;
		array_push(self::$tracelist,array(self::$errtype[$type],$message));
		Logger::dump($type,$message);
	}
	
	//Fetches the error stack trace.
	static function fetchTrace() {
		return self::$tracelist;
	}
	
	//Fetches error status.
	static function hasErrors() {
		return self::$error;
	}
}

?>