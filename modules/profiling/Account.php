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
class Account extends ModuleSupport {
	
	/**
         * Creates a new user account.
         * 
         * @param mixed[] $info
         * @param int $status
         * @return null 
         */
	function createAccount($info,$status=0) {
		$keys=array_keys($info);
		array_push($keys,'status');
		$values=array_values($info);
		array_push($values,$status);
		Database::add('accounts',$keys,$values);
		$accno=mysql_insert_id();
		Database::add('profile',array('acc_no'),array($accno));
		$attr=array('alias','email','sex','dob','location');
		foreach($attr as $a) Database::add('privacy',array('acc_no','infofield','restriction'),array($accno,$a,0));
		if($status>0) EventHandler::fireEvent('joinednetwork',$accno);
		return null;
	}
	
	/**
         * Deletes a user account
         * 
         * @param int $accno
         * @return null 
         */
	function deleteAccount($accno) {
		EventHandler::fireEvent('leftnetwork',$accno);
		Database::remove('accounts',"acc_no=".$accno);
		return null;
	}
	
	/**
         * Updates an existing user account
         * 
         * @param int $accno
         * @param mixed[] $data
         * @return null 
         */
	function updateAccount($accno,$data) {
		$keys=array_keys($data);
		$values=array();
		$valid=array();
		$struct=Database::fetchStructure('accounts');
		foreach($struct as $s) array_push($valid,$s[0]);
		$cols=array();
		foreach($keys as $k) {
			if(in_array($k,$valid)) {
				array_push($cols,$k);
				array_push($values,$data[$k]);
			} else EventHandler::fire('args','Invalid field specified for update.');
		}
		Database::update('accounts',$cols,$values,"acc_no=".$accno);
		if(array_key_exists('status',$data) && $data['status']>0) EventHandler::fireEvent('joinednetwork',$accno);
		return null;
	}
	
	/**
         * Fetches user account information for a specific user
         * 
         * @param int $accno
         * @return mixed[] 
         */
	function fetchAccountInfo($accno) {
		$set=Database::get('accounts','email,firstname,middlename,lastname,status',"acc_no=".$accno);
		return $set[0];
	}
}

?>
