<?php

class SearchController extends Controller {
	
	function __construct() {
		//Method associations with sub-modules.
		$this->assoc['search']='Search';
		$this->assoc['searchPeople']='PeopleSearch';
		$this->assoc['searchMembers']='PeopleSearch';
		$this->assoc['searchGroup']='GroupSearch';
		$this->assoc['searchPosts']='PostSearch';
	
		//Locations of the sub-modules.
		$this->loc['Search']='Search.php';
		$this->loc['PeopleSearch']='PeopleSearch.php';
		$this->loc['GroupSearch']='GroupSearch.php';
		$this->loc['PostSearch']='PostSearch.php';
	}
}

?>
