<?php

class Frisby {
	//An object of the setup class.
	private $setup;
	
	//The dispatcher object.
	private $dispatcher;
	
	//Accesible methods of the Setup class.
	private $setupmethods=array(
		'setup_installDBSchema'=>'installDBSchema',
		'setup_installDBTriggers'=>'installDBTriggers',
		'setup_installDB'=>'installDB',
		'setup_uninstallDB'=>'uninstallDB'
	);
	
	//Initializes the engine.
	function __construct() {
		//Initializes the dispatcher.
		require_once('Dispatcher.php');
		$this->dispatcher=new Dispatcher();
		
		//Initializes the setup.
		require_once('Setup.php');
		$this->setup=new Setup();
	}
	
	//Boots up the engine and invokes the dispatcher.
	function call($method) {
		//Runs setup methods.
		if(strrpos($method,'setup_')!==false) {
			if(!array_key_exists($method,$this->setupmethods)) {
				ErrorHandler::fire('reg','Invalid Setup Method.');
				return array(false,ErrorHandler::fetchTrace());
			}
			$method=$this->setupmethods[$method];
			$this->setup->$method();
			if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
			else return array(true,null);
		}
		
		//Runs installer.
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		if(!$this->setup->checkSetup()) $this->setup->run();
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		
		//Dispatch via dispatcher.
		$data=func_get_args();
		$data=array_slice($data,1);
		$result=$this->dispatcher->dispatch($method,$data);
		return $result;
	}
}

?>
