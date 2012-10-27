<?php
/**
 * This file contains the ProfileController class.
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
 * An instance of this class is used to register methods of the profile module.
 * 
 * <code>
 * require_once('ProfileController.php');
 * 
 * $ctrl=new ProfileController();
 * $ctrl->invoke('method_name',array(var1,...));
 * </code> 
 */
class ProfileController extends Controller {
	
        /**
         * Registers methods of the profile module 
         */
	function __construct() {
		//Method associations with sub-modules.
		$this->assoc['createAccount']='Account';
		$this->assoc['deleteAccount']='Account';
		$this->assoc['updateAccount']='Account';
		$this->assoc['fetchAccountInfo']='Account';
		$this->assoc['createProfile']='Profile';
		$this->assoc['setAvatar']='Profile';
		$this->assoc['deleteProfile']='Profile';
		$this->assoc['updateProfile']='Profile'; 
		$this->assoc['fetchProfile']='Profile';
		$this->assoc['setPrivacy']='Privacy';
		$this->assoc['getPrivacy']='Privacy';
		$this->assoc['registerProfileAttribute']='ExtendedProfile';
		$this->assoc['unregisterProfileAttribute']='ExtendedProfile';
		$this->assoc['getAttributeNames']='ExtendedProfile';
		
		//Locations of the sub-modules.
		$this->loc['Account']='Account.php';
		$this->loc['Profile']='Profile.php';
		$this->loc['Privacy']='Privacy.php';
		$this->loc['ExtendedProfile']='ExtendedProfile.php';
	}
}

?>
