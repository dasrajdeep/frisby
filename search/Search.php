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
 */
class Search {
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
         * Searches by names in specified domains
         * 
         * @param array $querydata
         * @param array $domain
         * @return array 
         */
	function search($querydata,$domain) {
		ErrorHandler::reset();
		$results=array();
		foreach($domain as $d) {
			if($d=='people') {
				$mod=$this->ctrl->loadSubModule('searchPeople');
				$results['people']=$mod->searchPeople(array('name'=>$querydata));
			}
			else if($d=='groups') {
				$mod=$this->ctrl->loadSubModule('searchGroup');
				$results['groups']=$mod->searchGroup(array('name'=>$querydata));
			}
			else if($d=='posts') {
				$mod=$this->ctrl->loadSubModule('searchPosts');
				$results['posts']=$mod->searchPosts(array('text'=>$querydata));
			}
		}
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		return array(true,$results);
	}
}

?>
