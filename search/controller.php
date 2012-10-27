<?php
/**
 * This file contains the SearchController class.
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
 * An instance of this class is used to register methods of the search module.
 * 
 * <code>
 * require_once('SearchController.php');
 * 
 * $ctrl=new SearchController();
 * $ctrl->invoke('method_name',array(var1,...));
 * </code> 
 */
class SearchController extends Controller {
	
        /**
         * Registers methods of the search module 
         */
	function __construct() {
		//Method associations with sub-modules.
		$this->assoc['search']='Search';
		$this->assoc['searchPeople']='PeopleSearch';
		$this->assoc['searchMembers']='PeopleSearch';
		$this->assoc['searchGroup']='GroupSearch';
		$this->assoc['searchPosts']='PostSearch';
	
		//Locations of the sub-modules.
		$this->loc['Search']='Search.php';
		$this->loc['PeopleSearch']='PeopleSearch.php';
		$this->loc['GroupSearch']='GroupSearch.php';
		$this->loc['PostSearch']='PostSearch.php';
	}
}

?>
