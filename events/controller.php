<?php

class SearchController extends Controller {
	
	function __construct() {
		//Method associations with sub-modules.
		$this->assoc['registerEvent']='EventRegister';
		$this->assoc['unregisterEvent']='EventRegister';
		$this->assoc['fetchNames']='EventRegister';
		$this->assoc['fetchCategories']='EventRegister';
		$this->assoc['fireEvent']='Event';
		$this->assoc['updateStatus']='Event';
		$this->assoc['fetchEventsByCategory']='Event';
		$this->assoc['fetchEventsByEntity']='Event';
	
		//Locations of the sub-modules.
		$this->loc['EventRegister']='EventRegister.php';
		$this->loc['Event']='Event.php';
	}
}

?>
