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
 */
class Read {
	/**
         * Contains a reference to the module controller
         * 
         * @var object
         */
	private $ctrl=null;
	
	/**
         * Passes a reference of the module controller to this object
         * 
         * @param object $ref 
         */
	function __construct($ref) {
		$this->ctrl=$ref;
	}
	
	/**
         * Fetches publications on a specific node
         * 
         * @param int $nodetype
         * @param int $node
         * @param int $limit
         * @return array 
         */
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
	
	/**
         * Fetches a specific publication
         * 
         * @param int $postid
         * @return array 
         */
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
	
        /**
         * Fetches the MIME content associated with a publication
         * 
         * @param int $id
         * @return array 
         */
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
