<?php
/**
 * This file contains the Account class.
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
 * An instance of this class is used to manage user accounts in the social network.
 * 
 * <code>
 * require_once('Account.php');
 * 
 * $acc=new Account();
 * $data=array('firstname'=>'Frisby','lastname'=>'Developer','email'=>'name@example.com');
 * $acc->createAccount($data);
 * </code> 
 * 
 * @package frisby\profiling
 */
class Account {
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
         * Creates a new user account
         * 
         * @param array $info
         * @param int $status
         * @return array 
         */
	function createAccount($info,$status=0) {
		ErrorHandler::reset();
		$keys=array_keys($info);
		array_push($keys,'status');
		$values=array_values($info);
		array_push($values,$status);
		Database::add('accounts',$keys,$values);
		if($status>0) EventHandler::fire('joinednetwork',mysql_insert_id());
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		else return array(true,null);
	}
	
	/**
         * Deletes a user account
         * 
         * @param int $accno
         * @return array 
         */
	function deleteAccount($accno) {
		ErrorHandler::reset();
		EventHandler::fire('leftnetwork',$accno);
		Database::remove('accounts',"acc_no=".$accno);
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		else return array(true,null);
	}
	
	/**
         * Updates an existing user account
         * 
         * @param int $accno
         * @param array $data
         * @return array 
         */
	function updateAccount($accno,$data) {
		ErrorHandler::reset();
		$keys=array_keys($data);
		$values=array();
		foreach($keys as $k) array_push($values,$data[$k]);
		Database::update('accounts',$keys,$values,"acc_no=".$accno);
		if(array_key_exists('status',$data) && $data['status']>0) EventHandler::fire('joinednetwork',$accno);
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		else return array(true,null);
	}
	
	/**
         * Fetches user account information for a specific user
         * 
         * @param int $accno
         * @return array 
         */
	function fetchAccountInfo($accno) {
		ErrorHandler::reset();
		$set=Database::get('accounts','email,firstname,middlename,lastname,status',"acc_no=".$accno);
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		else return array(true,$set[0]);
	}
}

?>
