<?php
/**
 * This file contains the GroupSearch class.
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

 namespace frisby;
 
/**
 * An instance of this class is used to search for groups in the social network.
 * 
 * <code>
 * require_once('GroupSearch.php');
 * 
 * $search=new GroupSearch();
 * $data=array('name'=>'some_group');
 * $resultset=$search->searchGroup($data);
 * </code> 
 * 
 * @package frisby\search
 */
class GroupSearch extends ModuleSupport {
	
	/**
         * Searches for groups.
         * 
         * @param mixed[] $querydata
         * @return mixed[] 
         */
	function searchGroup($querydata) {
		$keys=array_keys($querydata);
		$patterns=array();
		foreach($keys as $k) {
			if($k==='name') array_push($patterns,sprintf("%s like '%%%s%%'",$k,$querydata[$k]));
			else if($k==='description') array_push($patterns,sprintf("%s like '%%%s%%'",$k,$querydata[$k]));
			else if($k==='type') array_push($patterns,"type=".$querydata['type']);
			else if($k==='creationdate') array_push($patterns,sprintf("creationdate>='%s'",$querydata['creationdate']));
			else EventHandler::fireError('arg','Invalid domain name specified for search.');
		}
		$matcher=implode(' and ',$patterns);
		$set=Database::get('groups','*',$matcher);
		return $set;
	}
}

?>
