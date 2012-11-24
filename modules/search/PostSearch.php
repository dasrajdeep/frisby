<?php
/**
 * This file contains the PostSearch class.
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
 * An instance of this class is used to search publications within the social network.
 * 
 * <code>
 * require_once('PostSearch.php');
 * 
 * $search=new PostSearch();
 * $data=array('text'=>'something');
 * $resultset=$search->searchPosts($data);
 * </code> 
 * 
 * @package frisby\search
 */
class PostSearch extends ModuleSupport {
	
	/**
         * Searches for publications within the entire network.
         * 
         * @param mixed[] $querydata
         * @return mixed[] 
         */
	function searchPosts($querydata) {
		$keys=array_keys($querydata);
		$valid=array('post_id','publisher','thread','node');
		$parts=array();
		foreach($keys as $k) {
			if($k==='timestamp') array_push($parts,sprintf("timestamp>='%s'",$querydata['timestamp']));
			else if($k==='text') array_push($parts,sprintf("textdata like '%%%s%%'",$querydata['text']));
			else if(in_array($k,$valid)) array_push($parts,$k."=".$querydata[$k]);
			else EventHandler::fire('args','Invalid search field specified.');
		}
		$matcher=implode(' and ',$parts);
		$set=Database::get('posts','*',$matcher);
		return $set;
	}
}

?>
