<?php

class Controller {
	//An associative array containing the associations of methods with the sub-modules.
	protected $assoc=array();
	
	//An associative array containing the location of the sub-modules.
	protected $loc=array();
	
	//Loads the required sub-module for the child controller.
	protected function loadSubModule($method) {
		//Check whether method is registered with the controller.
		if(!array_key_exists($method,$this->assoc)) {
			ErrorHandler::fire('int','Method not registered with controller.');
			return null;
		}
		
		//Load the sub-module.
		require_once($this->loc[$this->assoc[$method]]);
		
		//Create an object of the sub-module.
		$submod=new $this->assoc[$method]($this);
		
		//If all executes successfully.
		return $submod;
	}
}

?>
