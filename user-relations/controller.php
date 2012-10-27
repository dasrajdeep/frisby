<?php
/**
 * This file contains the UserRelationsController class.
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
 * An instance of this class is used to register methods of the user-relations module.
 * 
 * <code>
 * require_once('UserRelationsController.php');
 * 
 * $ctrl=new UserRelationsController();
 * $ctrl->invoke('method_name',array(var1,...));
 * </code> 
 */
class UserRelationsController extends Controller {
	
        /**
         * Registers methods of the user-relations module 
         */
	function __construct() {
		//Method associations with sub-modules.
		$this->assoc['createRelation']='UserRelations';
		$this->assoc['confirmRelation']='UserRelations';
		$this->assoc['updateRelation']='UserRelations';
		$this->assoc['fetchRelationInfo']='UserRelations';
	
		//Locations of the sub-modules.
		$this->loc['UserRelations']='UserRelations.php';
	}
}

?>
