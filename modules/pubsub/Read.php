<?php
/**
 * This file contains the Read class.
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

/**
 * An instance of this class is used to retrieve publications.
 * 
 * <code>
 * require_once('Read.php');
 * 
 * $read=new Read();
 * $resultset=$read->fetchPosts(0,nodeid,1000);
 * </code> 
 * 
 * @package frisby\pubsub
 */
class Read extends ModuleSupport {
	
	/**
         * Fetches publications on a specific node.
         * 
         * @param int $nodetype
         * @param int $node
         * @param string $age
         * @return mixed[] 
         */
	function fetchPosts($nodetype,$node,$age) {
		$fields='post_id,publisher,textdata,timestamp,thread,mime';
		$criterion=sprintf("node=(select node_id from %snodes where type=%s and ref_id=%s) and timestamp>'%s' order by timestamp desc",Database::getPrefix(),$nodetype,$node,$age);
		$set=Database::get(sprintf('posts',Database::getPrefix()),$fields,$criterion);
		for($i=0;$i<count($set);$i++) {
			if($set[$i]['mime']>0) $set[$i]['mime']=$this->getMime($set[$i]['mime']);
		}
		return $set;
	}
	
	/**
         * Fetches text only publications on a specific node.
         * 
         * @param int $nodetype
         * @param int $node
         * @param string $age
         * @return mixed[] 
         */
	function fetchTextPosts($nodetype,$node,$age) {
		$criterion=sprintf("node=(select node_id from %snodes where type=%s and ref_id=%s) and timestamp>'%s' order by timestamp desc",Database::getPrefix(),$nodetype,$node,$age);
		$set=Database::get('view_posts','*',$criterion);
		return $set;
	}
	
	/**
         * Fetches a specific publication.
         * 
         * @param int $postid
         * @return mixed[] 
         */
	function getPost($postid) {
		$fields='post_id,publisher,textdata,timestamp,thread,mime';
		$criterion=sprintf("post_id=%s",$postid);
		$set=Database::get(sprintf('posts',Database::getPrefix()),$fields,$criterion);
		if($set) {
			$set=$set[0];
			if($set['mime']>0) $set['mime']=$this->getMime($set['mime']);
		}
		return $set[0];
	}
	
        /**
         * Fetches the MIME content associated with a publication.
         * 
         * @param int $id
         * @return mixed[] 
         */
	private function getMime($id) {
		$m=Database::get('mime','type,ref_id',"mime_id=".$id);
		$m=$m[0];
		if($m['type']==1) {
			$set=Database::get('images','imgdata,type',"img_id=".$m['ref_id']);
			if($set) $set=array(base64_encode($set[0]['imgdata']),$set[0]['type']);
			return array(1,$set);
		}
		else if($m['type']>1) {
			$ext=Database::get('external','resource_name,resource_id',"ext_id=".$m['ref_id']);
			return array($m['type'],$ext[0]);
		}
	}
}

?>
