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
 * 
 * @package frisby\profiling
 */
class Profile extends ModuleSupport {
	
	/**
         * Sets an avatar for a user profile.
         * 
         * @param int $accno
         * @param string $img
         * @return null 
         */
	function setAvatar($accno,$img) {
		$iminfo=getimagesize($img);
		$imgdata=addslashes(file_get_contents($img));
		Database::add('images',array('type','imgdata','width','height','bits'),array($iminfo['mime'],$imgdata,$iminfo[0],$iminfo[1],$iminfo['bits']));
		$newid=mysql_insert_id();
		$old=Database::get('profile','avatar',"acc_no=".$accno);
		if($old && $old[0]['avatar']) $old=$old[0]['avatar'];
		if($old && $old>1) Database::remove('images',"img_id=".$old);
		Database::update('profile',array('avatar'),array($newid),"acc_no=".$accno);
		return null;
	}
	
	/**
         * Updates a user profile.
         * 
         * @param int $accno
         * @param mixed[] $data
         * @return null 
         */
	function updateProfile($accno,$data) {
		$keys=array_keys($data);
		$values=array();
		foreach($keys as $k) array_push($values,$data[$k]);
		Database::update('profile',$keys,$values,"acc_no=".$accno);
		EventHandler::fireEvent('updatedprofile',$accno);
		return null;
	}
	
	/**
         * Fetches user profile information.
         * 
         * @param int $accno
         * @param string[] $attrs
         * @return mixed[] 
         */
	function fetchProfile($accno,$attrs) {
		$cols='*';
		if(func_num_args()==2 && count($attrs)>0) $cols=implode(',',$attrs);
		$result=Database::get('view_profile',$cols,"acc_no=".$accno);
                if(isset($result[0]['avatarimage'])) $result[0]['avatarimage']=base64_encode($result[0]['avatarimage']);
		return $result[0];
	}
}

?>
