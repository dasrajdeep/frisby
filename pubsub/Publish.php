<?php

class Publish {
	//Reference to the calling controller.
	private $ctrl=null;
	
	//Stores the reference to the caller.
	function __construct($ref) {
		$this->ctrl=$ref;
	}
	
	//Creates a new post.
	function createPost($accno,$noderef,$thread,$data) {
		ErrorHandler::reset();
		$ref=$this->handleMIME($data['mime_type'],$data['mime']);
		$pre=Database::getPrefix();
		$node=Database::get('nodes','node_id',sprintf("type=%s and ref_id=%s",$noderef[0],$noderef[1]));
		if($node) $node=$node[0]['node_id'];
		$values=sprintf("%s,'%s',%s,%s,%s",$accno,$data['text'],$ref,$pre,$node,$thread);
		Database::query("insert into %sposts (publisher,textdata,mime,node,thread) values (%s)",$pre,$values);
		EventHandler::fire('creatednewpost',$accno,mysql_insert_id());
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		else return array(true,null);
	}
	
	//Removes a post.
	function deletePost($postid) {
		ErrorHandler::reset();
		$pre=Database::get('posts','mime',"post_id=".$postid);
		if($pre) $pre=$pre[0]['mime'];
		if($pre>0) {
			$m=Database::get('mime','type,ref_id',"mime_id=".$pre);
			if($m[0]['type']==0) Database::remove('images',"img_id=".$m[0]['ref_id']);
			else if($m[0]['type']>0) {
				$ext=Database::get('extensions','table_name',"type=".$m[0]['type']);
				if($ext) Database::remove(sprintf('%smime_%s',Database::getPrefix(),$ext[0]['table_name']),"id=".$m[0]['ref_id']);
			}
			Database::remove('mime',"mime_id=".$pre);
		}
		Database::remove('posts',"post_id=".$postid);
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		else return array(true,null);
	}
	
	//Handles the MIME content associated with a post.
	private function handleMIME($type,$datasrc) {
		if($type==0) return 0;
		//Handle image content.
		else if($type==1) {
			$iminfo=getimagesize($datasrc);
			$imgdata=addslashes(file_get_contents($datasrc));
			Database::add('images',array('type','imgdata','width','height','bits'),array($iminfo['mime'],$imgdata,$iminfo[0],$iminfo[1],$iminfo['bits']));
			$newid=mysql_insert_id();
			Database::add('mime',array('type','ref_id'),array(0,$newid));
			$newid=mysql_insert_id();
			return $newid;
		}
		//Handle other MIME content. Requires external plugins.
		else if($type>1) {
			$type--;
			$tmp=Database::get('extensions','table_name',"type=".$type);
			if($tmp) {
				Database::add(sprintf('%smime_%s',Database::getPrefix(),$tmp[0]['table_name']),array('name','ref_id'),array($datasrc[0],$datasrc[1]));
				$newid=mysql_insert_id();
				Database::add('mime',array('type','ref_id'),array($type,$newid));
				$newid=mysql_insert_id();
				return $newid;
			}
		}
	}
}

?>
