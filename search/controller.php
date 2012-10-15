<?php

class SearchController extends Controller {
	
	function __construct() {
		//Method associations with sub-modules.
		$this->assoc['search']='Search';
		$this->assoc['searchPeople']='PeopleSearch';
		$this->assoc['searchMembers']='PeopleSearch';
		$this->assoc['searchGroup']='GroupSearch';
		$this->assoc['searchAllPosts']='PostSearch';
		$this->assoc['searchNode']='PostSearch';
	
		//Locations of the sub-modules.
		$this->loc['Search']='Search.php';
		$this->loc['PeopleSearch']='PeopleSearch.php';
		$this->loc['GroupSearch']='GroupSearch.php';
		$this->loc['PostSearch']='PostSearch.php';
	}
	
	//The master method to invoke the appropriate method.
	function invoke($method,$data) {
		//Loads the sub-module if the method is registered with the controller.		
		if(!$this->loadSubModule($method)) return array(false,ErrorHandler::fetchTrace());
		
		//Invoke method of sub-module.
	}
}

?>
