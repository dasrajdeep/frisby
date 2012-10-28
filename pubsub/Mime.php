<?php
/**
 * This file contains the Mime class.
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
 * An instance of this class is used to manage MIME content for posts.
 * 
 * <code>
 * require_once('Mime.php');
 * 
 * $mime=new Mime();
 * $mime->createMimeSchema('relation_name',1);
 * </code> 
 * 
 * @package frisby\pubsub
 */
class Mime {
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
         * Creates a new MIME database relation
         * 
         * @param string $name
         * @param int $type
         * @return array 
         */
	function createMimeSchema($name,$type) {
		ErrorHandler::reset();
		Database::query(sprint("create table %smime_%s (
			id int not null auto_increment,
			name varchar(100),
			ref_id varchar(150) not null,
			primary key(id)
		) engine=INNODB",Database::getPrefix(),$name));
		Database::add('extensions',array('type','table_name'),array($type,$name));
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		else return array(true,null);
	}
	
	/**
         * Deletes a MIME database relation from the database
         * 
         * @param string $name
         * @return array 
         */
	function deleteMimeSchema($name) {
		ErrorHandler::reset();
		Database::query(sprintf("drop table if exists %smime_%s",Database::getPrefix(),$name));
		Database::remove('extensions',sprintf("table_name='%s'",$name));
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		else return array(true,null);
	}
	
	/**
         * Fetches all the MIME schemas defined by the administrator
         * 
         * @return array
         */
	function fetchSchemas() {
		ErrorHandler::reset();
		$set=Database::get('extensions','table_name',false);
		$schemas=array();
		foreach($set as $s) array_push($schemas,$s['table_name']);
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		else return array(true,$schemas);
	}
}

?>
