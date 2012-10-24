<?php

class PostSearch {
	//Reference to the calling controller.
	private $ctrl=null;
	
	//Stores the reference to the caller.
	function __construct($ref) {
		$this->ctrl=$ref;
	}
	
	//Searches for all posts in the network containing a selected topic.
	function searchPosts($querydata) {
		ErrorHandler::reset();
		$parts=array();
		if(isset($querydata['publisher'])) array_push($parts,"publisher=".$querydata['publisher']);
		if(isset($querydata['text'])) array_push($parts,sprintf("textdata like '%%%s%%'",$querydata['text']));
		if(isset($querydata['node'])) array_push($parts,"node=".$querydata['node']);
		$matcher=implode(' and ',$parts);
		if(isset($querydata['maxposts'])) $matcher.=' limit '.$querydata['maxposts'];
		$set=Database::get('posts','*',$matcher);
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		return array(true,$set);
	}
}

?>
