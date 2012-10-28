<?php
/**
 * This file contains the Setup class used in setting up the engine.
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
 * An instance of this class is used to install/uninstall the database schema along with its default data.
 * 
 * <code>
 * require_once('Setup.php');
 * 
 * $setup=new Setup();
 * $setup->run();
 * </code> 
 * 
 * @package frisby\core
 */
class Setup {
	
	/**
         * Checks if the database is properly configured or not
         * 
         * @return boolean 
         */
	function checkSetup() {
		require('config/schema_tables.inc');
		$keys=array_keys($tables);
		foreach($keys as $t) Database::get($t,'*',false);
		if(ErrorHandler::hasErrors()) return false;
		else return true;
	}
	
	/**
         * This method first uninstalls the currently installed schema and then reinstalls it 
         */
	function run() {
		ErrorHandler::reset();
		$this->uninstallDB();
		$this->installDB();
	}
	
	/**
         * Installs the database schema 
         */
	function installDB() {
		$this->installDBSchema();
		$this->installViews();
		$this->installDBTriggers();
		$this->installData();
	}
	
	/**
         * Installs the tables of the schema 
         */
	function installDBSchema() {
		$pre=Database::getPrefix();
		require('config/schema_tables.inc');
		foreach($tables as $q) Database::query(str_replace('%s',$pre,$q));
	}
	
	/**
         * Inserts default data into the installed schema 
         */
	private function installData() {
		Database::add('mime',array('mime_id','type','ref_id'),array(0,0,0));
		require('config/schema_data.inc');
		foreach($events as $e) Database::add('events',array('category','event_name','description'),array($e[1],$e[0],$e[2]));
		$imgsrc='data/default_avatar.jpg';
		$iminfo=getimagesize($imgsrc);
		$img=addslashes(file_get_contents($imgsrc));
		Database::query(sprintf("insert into %simages (type,imgdata,width,height,bits) values ('%s','%s',%s,%s,%s)",Database::getPrefix(),$iminfo['mime'],$img,$iminfo[0],$iminfo[1],$iminfo['bits']));
	}
	
	/**
         * Installs the views of the schema 
         */
	private function installViews() {
		require('config/schema_views.inc');
		$pre=Database::getPrefix();
		foreach($views as $v) Database::query(str_replace('%s',$pre,$v));
	}
	
	/**
         * Installs the triggers of the schema 
         */
	function installDBTriggers() {
		require('config/schema_triggers.inc');
		$pre=Database::getPrefix();
		foreach($triggers as $q) Database::query(str_replace('%s',$pre,$q));
	}
	
	/**
         * Completely uninstalls the database schema 
         */
	function uninstallDB() {
		$ext=Database::get('extensions','table_name',false);
		foreach($ext as $e) Database::query(sprintf("drop table if exists %mime_%s",Database::getPrefix(),$e['table_name']));
		require('config/schema_uninstall.inc');
		$pre=Database::getPrefix();
		foreach($uninstallqueries as $q) Database::query(sprintf($q,$pre));
	}
	
}

?>
