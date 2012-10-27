<?php

class UserRelationsController extends Controller {
	
	function __construct() {
		//Method associations with sub-modules.
		$this->assoc['createRelation']='UserRelations';
		$this->assoc['confirmRelation']='UserRelations';
		$this->assoc['updateRelation']='UserRelations';
		$this->assoc['fetchRelationInfo']='UserRelations';
	
		//Locations of the sub-modules.
		$this->loc['UserRelations']='UserRelations.php';
	}
}

?>
