<?php

class Search {
	//Reference to the calling controller.
	private $ctrl=null;
	
	//Stores the reference to the caller.
	function __construct($ref) {
		$this->ctrl=$ref;
	}
	
	//A generic search for specific information types. Domain is a list of areas to search for.
	function search($querydata,$domain) {
		ErrorHandler::reset();
		$results=array();
		foreach($domain as $d) {
			if($d=='people') {
				$mod=$this->ctrl->loadSubModule('searchPeople');
				$results['people']=$mod->searchPeople($querydata);
			}
			else if($d=='groups') {
				$mod=$this->ctrl->loadSubModule('searchGroup');
				$results['groups']=$mod->searchGroup($querydata);
			}
			else if($d=='posts') {
				$mod=$this->ctrl->loadSubModule('searchPosts');
				$results['posts']=$mod->searchPosts($querydata);
			}
		}
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		return array(true,$results);
	}
}

?>
