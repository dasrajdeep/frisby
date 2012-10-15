<?php

class PubSubController extends Controller {
	
	function __construct() {
		//Method associations with sub-modules.
		$this->assoc['createPost']='Publish';
		$this->assoc['deletePost']='Publish';
		$this->assoc['fetchPosts']='Read';
		$this->assoc['getPost']='Read';
	
		//Locations of the sub-modules.
		$this->loc['Publish']='Publish.php';
		$this->loc['Read']='Read.php';
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
