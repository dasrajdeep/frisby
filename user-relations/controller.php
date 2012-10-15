<?php

class UserRelationsController extends Controller {
	
	function __construct() {
		//Method associations with sub-modules.
		$this->assoc['createRelation']='UserRelations';
		$this->assoc['confirmRelation']='UserRelations';
	
		//Locations of the sub-modules.
		$this->loc['UserRelations']='UserRelations.php';
	}
	
	//The master method to invoke the appropriate method.
	function invoke($method,$data) {
		//Loads the sub-module if the method is registered with the controller.		
		$submod=$this->loadSubModule($method);	
		if($submod==null) return array(false,ErrorHandler::fetchTrace());
		
		//Invoke method of sub-module.
	}
}

?>
