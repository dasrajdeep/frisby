<?php
/**
 * This file contains the Publish class.
 * 
 * PHP version 5.3
 * 
 * LICENSE: This file is part of Frisby.
 * Frisby is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * Frisby is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with Frisby. If not, see <http://www.gnu.org/licenses/>. 
 * 
 * @category   PHP
 * @package    Frisby
 * @author     Rajdeep Das <das.rajdeep97@gmail.com>
 * @copyright  Copyright 2012 Rajdeep Das
 * @license    http://www.gnu.org/licenses/gpl.txt  The GNU General Public License
 * @version    GIT: v1.0
 * @link       https://github.com/dasrajdeep/frisby
 * @since      File available since Release 1.0
 */

 namespace frisby;
 
/**
 * An instance of this class is used to manage publications.
 * 
 * <code>
 * require_once('Publish.php');
 * 
 * $pub=new Publish();
 * $data=array('text'=>'sample');
 * $pub->createPost(userid,array(nodetype,nodeid),threadid,$data);
 * </code> 
 * 
 * @package frisby\pubsub
 */
class Publish extends ModuleSupport {
	
	/**
         * Creates a new post.
         * 
         * @param int $accno
         * @param int $nodetype
		 * @param int $nodeid
         * @param int $thread
         * @param mixed[] $data
         * @return null 
         */
	function createPost($accno,$nodetype,$nodeid,$thread,$data) {
		$ref=$this->handleMIME($data['mime_type'],$data['mime']);
		$pre=Database::getPrefix();
		$node=Database::get('nodes','node_id',sprintf("type=%s and ref_id=%s",$nodetype,$nodeid));
		if($node) $node=$node[0]['node_id'];
		$values=sprintf("%s,'%s',%s,%s,%s",$accno,$data['text'],$ref,$node,$thread);
		Database::query(sprintf("insert into %sposts (publisher,textdata,mime,node,thread) values (%s)",$pre,$values));
		EventHandler::fireEvent('creatednewpost',$accno,mysql_insert_id());
		return null;
	}
	
	/**
         * Deletes a post.
         * 
         * @param int $postid
         * @return null 
         */
	function deletePost($postid) {
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
		return null;
	}
	
	/**
         * Handles the MIME content associated with a post
         * 
         * @param int $type
         * @param string $datasrc
         * @return int 
         */
	private function handleMIME($type,$datasrc) {
		if($type==0) return 1;
		//Handle image content.
		else if($type==1) {
			$iminfo=getimagesize($datasrc);
			$imgdata=addslashes(file_get_contents($datasrc));
			Database::add('images',array('type','imgdata','width','height','bits'),array($iminfo['mime'],$imgdata,$iminfo[0],$iminfo[1],$iminfo['bits']));
			$newid=mysql_insert_id();
			Database::add('mime',array('type','ref_id'),array($type,$newid));
			$newid=mysql_insert_id();
			return $newid;
		}
		//Handle other MIME content. Requires external plugins.
		else if($type>1) {
			Database::add('external',array('type','resource_id','resource_name'),array($type,$datasrc['resource'],$datasrc['name']));
			$newid=mysql_insert_id();
			Database::add('mime',array('type','ref_id'),array($type,$newid));
			$newid=mysql_insert_id();
			return $newid;
		}
	}
}

?>
