<?php

class Read {
	//Reference to the calling controller.
	private $ctrl=null;
	
	//Stores the reference to the caller.
	function __construct($ref) {
		$this->ctrl=$ref;
	}
	
	//Fetches post(s) from the database. Currently supports only images for MIME.
	function fetchPosts($nodetype,$node,$limit) {
		ErrorHandler::reset();
		$fields='post_id,publisher,textdata,timestamp,thread,mime';
		$criterion=sprintf("node=(select node_id from %snodes where type=%s and ref_id=%s) limit %s",Database::getPrefix(),$nodetype,$node,$limit);
		$set=Database::get(sprintf('posts',Database::getPrefix()),$fields,$criterion);
		for($i=0;$i<count($set);$i++) {
			if($set[$i]['mime']>0) $set[$i]['mime']=$this->getMime($set[$i]['mime']);
		}
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		return array(true,$set);
	}
	
	//Gets a specific post.
	function getPost($postid) {
		ErrorHandler::reset();
		$fields='post_id,publisher,textdata,timestamp,thread,mime';
		$criterion=sprintf("post_id=%s",$postid);
		$set=Database::get(sprintf('posts',Database::getPrefix()),$fields,$criterion);
		if($set) {
			$set=$set[0];
			if($set['mime']>0) $set['mime']=$this->getMime($set['mime']);
		}
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		return array(true,$set[0]);
	}
	
	//Fetches MIME content.
	private function getMime($id) {
		$m=Database::get('mime','type,ref_id',"mime_id=".$id);
		$m=$m[0];
		if($m['type']==0) {
			$set=Database::get('images','imgdata',"img_id=".$m['ref_id']);
			if($set) $set=$set[0]['imgdata'];
			return array(0,$set);
		}
		else {
			$ext=Database::get('extensions','table_name',"type=".$m['type']);
			if($ext) {
				$ext=$ext[0]['table_name'];
				$set=Database::get(sprintf('%smime_%s',Database::getPrefix(),$ext),'ref_id',"id=".$m['ref_id']);
				if($set) $set=$set[0]['ref_id'];
				return array($m['type'],$set);
			}
		}
	}
}

?>
