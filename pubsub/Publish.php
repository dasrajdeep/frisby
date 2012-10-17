<?php

class Publish {
	//Reference to the calling controller.
	private $ctrl=null;
	
	//Stores the reference to the caller.
	function __construct($ref) {
		$this->ctrl=$ref;
	}
	
	//Creates a new post.
	function createPost($accno,$node,$thread,$data) {
		ErrorHandler::reset();
		$ref=$this->handleMIME($data['mime_type'],$data['mime']);
		Database::add('posts',array('publisher','textdata','mime_type','mime','type','node','thread','timestamp'),array($accno,$data['text'],$data['mime_type'],$ref,0,$node,$thread,time()));
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		else return array(true,null);
	}
	
	//Removes a post.
	function deletePost($postid) {
		ErrorHandler::reset();
		$pre=Database::get('posts','mime',"mime_type=1 and post_id=".$postid);
		if($pre) $pre=$pre[0]['mime'];
		if($pre) Database::remove('images',"img_id=".$pre);
		Database::remove('posts',"post_id=".$postid);
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		else return array(true,null);
	}
	
	//Handles the MIME content associated with a post.
	private function handleMIME($type,$data) {
		if($type==0) return null;
		//Handle image content.
		else if($type==1) {
			$size=getimagesize($data[0]);
			$raw=file_get_contents($data[0]);
			$formed=addslashes($raw);
			$link=Database::add('images',array('type','size','imgdata'),array($data[1],$size,$formed));
			$newid=mysql_insert_id($link);
			return $newid;
		}
		//Handle other MIME content. Requires external plugins.
		else if($type>1) {}
	}
}

?>
