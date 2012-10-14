<?php

class Privacy {
	//Reference to the calling controller.
	private $ctrl=null;
	
	//Stores the reference to the caller.
	function __construct($ref) {
		$this->ctrl=$ref;
	}
	
	//Sets the privacy attributes for all or specific information.
	function setPrivacy($accno,$settings) {}
	
	//Gets privacy settings. A set of information attributes are provided to specify the requirement.
	function getPrivacy($accno,$infoset) {}
}

?>
