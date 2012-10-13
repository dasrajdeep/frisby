<?php
	//This section contains the mappings from the method names to the actual methods.
	
	//The map array.
	$map=array();
	
	//The routes array.
	$routes=array();
	
	//The mappings.
	$map['createacc']=array('Profile','createAccount');
	
	//The routes for the modules.
	$routes['Profile']='profiling/controller.php';

?>