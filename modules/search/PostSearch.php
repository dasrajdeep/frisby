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
		$parts=array();
		if(isset($querydata['publisher'])) array_push($parts,"publisher=".$querydata['publisher']);
		if(isset($querydata['text'])) array_push($parts,sprintf("textdata like '%%%s%%'",$querydata['text']));
		if(isset($querydata['node'])) array_push($parts,"node=".$querydata['node']);
		$matcher=implode(' and ',$parts);
		if(isset($querydata['maxposts'])) $matcher.=' limit '.$querydata['maxposts'];
		$set=Database::get('posts','*',$matcher);
		return $set;
	}
}

?>
