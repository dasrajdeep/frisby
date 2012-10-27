<?php
/**
 * This file contains the Profile class.
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
 * An instance of this class is used to manage user profiles in the social network.
 * 
 * <code>
 * require_once('Profile.php');
 * 
 * $prof=new Profile();
 * $data=array('sex'=>'male','location'=>'Honolulu');
 * $prof->createProfile(userid,$data);
 * </code> 
 */
class Profile {
	/**
         * Contains a reference of the module controller
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
         * Creates a new user profile
         * 
         * @param int $accno
         * @param array $data
         * @return array 
         */
	function createProfile($accno,$data) {
		ErrorHandler::reset();
		$keys=array_keys($data);
		$values=array();
		foreach($keys as $k) array_push($values,$data[$k]);
		array_push($keys,'acc_no');
		array_push($values,$accno);
		Database::add('profile',$keys,$values);
		$attr=array('alias','email','sex','dob','location');
		foreach($attr as $a) Database::add('privacy',array('acc_no','infofield','restriction'),array($accno,$a,0));
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		else return array(true,null);
	}
	
	/**
         * Sets an avatar image for a user profile
         * 
         * @param int $accno
         * @param string $img
         * @return array 
         */
	function setAvatar($accno,$img) {
		ErrorHandler::reset();
		$iminfo=getimagesize($img);
		$imgdata=addslashes(file_get_contents($img));
		Database::add('images',array('type','imgdata','width','height','bits'),array($iminfo['mime'],$imgdata,$iminfo[0],$iminfo[1],$iminfo['bits']));
		$newid=mysql_insert_id();
		$old=Database::get('profile','avatar',"acc_no=".$accno);
		if($old && $old[0]['avatar']) $old=$old[0]['avatar'];
		if($old && $old>1) Database::remove('images',"img_id=".$old);
		Database::update('profile',array('avatar'),array($newid),"acc_no=".$accno);
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		else return array(true,null);
	}
	
	/**
         * Deletes a user profile
         * 
         * @param int $accno
         * @return array 
         */
	function deleteProfile($accno) {
		ErrorHandler::reset();
		Database::remove('profile',"acc_no=".$accno);
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		else return array(true,null);
	}
	
	/**
         * Updates a user profile
         * 
         * @param int $accno
         * @param array $data
         * @return array 
         */
	function updateProfile($accno,$data) {
		ErrorHandler::reset();
		$keys=array_keys($data);
		$values=array();
		foreach($keys as $k) array_push($values,$data[$k]);
		Database::update('profile',$keys,$values,"acc_no=".$accno);
		EventHandler::fire('updatedprofile',$accno);
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		else return array(true,null);
	}
	
	/**
         * Fetches user profile information for a specific user
         * 
         * @param int $accno
         * @param array $attrs
         * @return array 
         */
	function fetchProfile($accno,$attrs) {
		ErrorHandler::reset();
		$cols='*';
		if(func_num_args()==2) $cols=implode(',',$attrs);
		$result=Database::get('view_profile',$cols,"acc_no=".$accno);
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		else return array(true,$result[0]);
	}
}

?>
