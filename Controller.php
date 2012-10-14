<?php

class Controller {
	//An associative array containing the associations of methods with the sub-modules.
	protected $assoc=array();
	
	//An associative array containing the location of the sub-modules.
	protected $loc=array();
	
	//An object of the sub-module to be used.
	protected $submod=null;
	
	protected function loadSubModule($method) {
		//Check whether method is registered with the controller.
		if(!array_key_exists($method,$this->assoc)) {
			ErrorHandler::fire('int','Method not registered with controller.');
			return false;
		}
		
		//Load the sub-module.
		require_once($this->loc[$this->assoc[$method]]);
		
		//Create an object of the sub-module.
		$this->submod=new $this->assoc[$method]($this);
		
		//If all executes successfully.
		return true;
	}
}

?>
