<?php
/**
 * This file contains the Privacy class.
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
 * An instance of this class is used to manage privacy settings for a user profile.
 * 
 * <code>
 * require_once('Privacy.php');
 * 
 * $priv=new Privacy();
 * $settings=array('sex'=>1,'dob'=>1);
 * $priv->setPrivacy(userid,$settings);
 * </code> 
 * 
 * @package frisby\profiling
 */
class Privacy extends ModuleSupport {
	
	/**
         * Updates privacy settings for a user profile.
         * 
         * @param int $accno
         * @param mixed[] $settings
         * @return null 
         */
	function setPrivacy($accno,$settings) {
		$keys=array_keys($settings);
		foreach($keys as $k) Database::update('privacy',array('restriction'),array($settings[$k]),sprintf("acc_no=%s and infofield='%s'",$accno,$k));
		return null;
	}
	
	/**
         * Fetches privacy settings for a user profile.
         * 
         * @param int $accno
         * @param string[] $infoset
         * @return mixed[] 
         */
	function getPrivacy($accno,$infoset) {
		$cnt=func_num_args();
		$set=null;
		if($cnt==2) {
			for($i=0;$i<count($infoset);$i++) $infoset[$i]=sprintf("'%s'",$infoset[$i]);
			$set=implode(',',$infoset);
			$result=Database::get('privacy','infofield,restriction',sprintf("acc_no=%s and infofield in (%s)",$accno,$set));
		} 
		else $result=Database::get('privacy','infofield,restriction',"acc_no=".$accno);
		$privacy=array();
		foreach($result as $r) $privacy[$r['infofield']]=$r['restriction'];
		return $privacy;
	}
}

?>
