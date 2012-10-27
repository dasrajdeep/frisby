<?php
/**
 * This file contains the PubSubController class.
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
 * An instance of this class is used to register methods of the pubsub module.
 * 
 * <code>
 * require_once('PubSubController.php');
 * 
 * $ctrl=new PubSubController();
 * $ctrl->invoke('method_name',array(var1,...));
 * </code> 
 */
class PubSubController extends Controller {
	
        /**
         * Registers methods of the pubsub module 
         */
	function __construct() {
		//Method associations with sub-modules.
		$this->assoc['createPost']='Publish';
		$this->assoc['deletePost']='Publish';
		$this->assoc['fetchPosts']='Read';
		$this->assoc['getPost']='Read';
		$this->assoc['createMimeSchema']='Mime';
		$this->assoc['deleteMimeSchema']='Mime';
		$this->assoc['fetchSchemas']='Mime';
	
		//Locations of the sub-modules.
		$this->loc['Publish']='Publish.php';
		$this->loc['Read']='Read.php';
		$this->loc['Mime']='Mime.php';
	}
}

?>
