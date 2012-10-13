<?php

class Dispatcher {
	
	//Constructor to initialize the dispatcher.
	function __construct() {
		//Dispatcher first initializes the logger.
		require_once('Logger.php');
		Logger::init();
		
		//Dispatcher initializes the error handler.
		require_once('ErrorHandler.php');

		//Dispatcher initializes the database.
		require_once('Database.php');
		Database::connect();

		//Dispatcher initializes the registry.
		require_once('Registry.php');
		Registry::init();

		//Registers a function to be executed when the process completes.
		register_shutdown_function('cleanup');
	}
	
	//Performs housekeeping on completion of process.
	static function cleanup() {
		Database::disconnect();
		Logger::shutdown();
	}
	
	//Service requests made by application. Dispatcher returns an object (result/data) to the caller upon completion.
	function dispatch($method,$data) {
		$route=Registry::read($method);
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		Registry::load($route[0]);
		$controllerName=$route[0].'Controller';
		$control=new $controllerName();
		$result=$control->invoke($route[1]);
		return $result;
	}
	
}

?>