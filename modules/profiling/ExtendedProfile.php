<?php
/**
 * This file contains the ExtendedProfile class.
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
 * An instance of this class is used to modify profile attributes.
 * 
 * <code>
 * require_once('ExtendedProfile.php');
 * 
 * $ep=new ExtendedProfile();
 * $ep->registerProfileAttribute('attribute_name','varchar(100)');
 * </code> 
 * 
 * @package frisby\profiling
 */
class ExtendedProfile extends ModuleSupport {
	
	/**
         * Registers a new profile attribute. 
         * 
         * @param string $name
         * @param string $datatype
         * @return null 
         */
	function registerProfileAttribute($name,$datatype) {
		Database::query(sprintf("alter table %sprofile add column %s %s",Database::getPrefix(),$name,$datatype));
		$set=Database::get('privacy','distinct acc_no as acc',false);
		foreach($set as $s) Database::add('privacy',array('acc_no','infofield'),array($s['acc'],$name));
		return null;
	}
	
	/**
         * Removes a profile attribute
         * 
         * @param string $name
         * @return null 
         */
	function unregisterProfileAttribute($name) {
		Database::query(sprintf("alter table %sprofile drop column %s",Database::getPrefix(),$name));
		Database::remove('privacy',sprintf("infofield='%s'",$name));
		return null;
	}
	
	/**
         * Fetches all the profile attribute names 
         * 
         * @return string[]
         */
	function getProfileAttributeNames() {
		$p=Database::query(sprintf("desc %sprofile",Database::getPrefix()));
		$names=array();
		while($r=mysql_fetch_assoc($p)) if($r['Field']!=='acc_no') array_push($names,$r['Field']);
		return $names;

	}
}

?>
