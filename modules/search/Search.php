<?php
/**
 * This file contains the Search class.
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
 * An instance of this class is used to carry out a generic search.
 * 
 * <code>
 * require_once('Search.php');
 * 
 * $search=new Search();
 * $resultset=$search->search('something',array('people','groups','posts'));
 * </code> 
 * 
 * @package frisby\search
 */
class Search extends ModuleSupport {

	/**
         * Searches by names in specified domains.
         * 
         * @param string $querydata
         * @param string[] $domain
         * @return mixed[] 
         */
	function search($querydata,$domain) {
		ErrorHandler::reset();
		$results=array();
		foreach($domain as $d) {
			if($d=='people') {
				$mod=loadSubModule('searchPeople');
				$results['people']=$mod->searchPeople(array('name'=>$querydata));
			}
			else if($d=='groups') {
				$mod=loadSubModule('searchGroup');
				$results['groups']=$mod->searchGroup(array('name'=>$querydata));
			}
			else if($d=='posts') {
				$mod=loadSubModule('searchPosts');
				$results['posts']=$mod->searchPosts(array('text'=>$querydata));
			}
		}
		return $results;
	}
}

?>
