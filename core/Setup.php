<?php
/**
 * This file contains the Setup class used by the engine.
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
 */

 namespace frisby;
 
/**
 * An instance of this class is used to install/uninstall the software.
 * 
 * <code>
 * require_once('Setup.php');
 * 
 * $setup=new Setup();
 * </code> 
 * 
 * @package frisby\core
 * @category   PHP
 * @author     Rajdeep Das <das.rajdeep97@gmail.com>
 * @copyright  Copyright 2012 Rajdeep Das
 * @license    http://www.gnu.org/licenses/gpl.txt  The GNU General Public License
 * @version    GIT: v1.0
 * @link       https://github.com/dasrajdeep/frisby
 * @since      Class available since Release 1.0
 */
class Setup {
	
	/**
         * Checks if the engine is properly configured or not.
         * 
         * @return boolean 
         */
	function checkSetup() {
		
		//Check database setup.
		require('../schema/schema_tables.inc');
		$required=array_keys($tables);
		
		$pre=Database::getPrefix();
		$set=Database::query(sprintf("select TABLE_NAME from information_schema.tables where TABLE_SCHEMA like '%s%%'",$pre));
		
		$installed=array();
		foreach($set as $s) array_push($installed,substr($s['TABLE_NAME'],strlen($pre)));
		
		foreach($required as $r) if(!in_array($r,$installed)) return false;
		
		//Check registry setup.
		$methods=Registry::getMethodNames();
		$scanned=$this->scanModules();
		$all=array();
		foreach($scanned as $s) foreach($s as $x) $all=array_merge($all,$x);
		foreach($all as $a) if(!in_array($a,$methods)) return false;
		
		return true;
	}
	
        /**
         * Installs the software. 
         */
	function installAll() {
		$this->installDB();
		$this->installRegistry();
	}
	
        /**
         * Installs the registry. 
         */
	function installRegistry() {
		Database::remove('registry',"true");
		$sc=$this->scanModules();
		$mods=array_keys($sc);
		foreach($mods as $m) {
			$classes=array_keys($sc[$m]);
			foreach($classes as $c) foreach($sc[$m][$c] as $x) Database::add('registry',array('method','classname','module'),array($x,$c,$m));
		}
	}
        
	/**
         * Installs the database schema. 
         */
	function installDB() {
		$this->installDBSchema();
		$this->installViews();
		$this->installDBTriggers();
		$this->installData();
	}
	
	/**
         * Installs the tables of the schema. 
         */
	function installDBSchema() {
		$pre=Database::getPrefix();
		require('../schema/schema_tables.inc');
		foreach($tables as $q) Database::query(str_replace('%s',$pre,$q));
	}
	
	/**
         * Inserts default data into the installed schema. 
         */
	private function installData() {
		Database::add('mime',array('mime_id','type','ref_id'),array(0,0,0));
		require('../schema/schema_data.inc');
		foreach($events as $e) Database::add('events',array('category','event_name','description'),array($e[1],$e[0],$e[2]));
		$imgsrc='../data/default_avatar.jpg';
		$iminfo=getimagesize($imgsrc);
		$img=addslashes(file_get_contents($imgsrc));
		
		$thumb=imagecreatefromstring($img);
		$image_width=imagesx($thumb);
		$image_height=imagesy($thumb);
		
		$temp=imagecreatetruecolor(150,150);
		imagecopyresampled($temp,$thumb,0,0,0,0,150,150,$image_width,$image_height);
		$thumb=imagecreatetruecolor(150,150);
		imagecopyresampled($thumb,$temp,0,0,0,0,150,150,150,150);
		
		ob_start();
		$type=substr($type,6);
		if($type==='jpeg') imagejpeg($thumb);
		else if($type==='gif') imagegif($thumb);
		else if($type==='png') imagepng($thumb); 
		$thumb=ob_get_contents();
		ob_end_clean();
		
		Database::query(sprintf("insert into %simages (type,image,thumb,width,height,bits) values ('%s','%s','%s',%s,%s,%s)",Database::getPrefix(),$iminfo['mime'],$img,$thumb,$iminfo[0],$iminfo[1],$iminfo['bits']));
	}
	
	/**
         * Installs the views of the schema. 
         */
	private function installViews() {
		require('../schema/schema_views.inc');
		$pre=Database::getPrefix();
		foreach($views as $v) Database::query(str_replace('%s',$pre,$v));
	}
	
	/**
         * Installs the triggers of the schema. 
         */
	function installDBTriggers() {
		require('../schema/schema_triggers.inc');
		$pre=Database::getPrefix();
		foreach($triggers as $q) Database::query(str_replace('%s',$pre,$q));
	}
	
	/**
         * Completely uninstalls the software. 
         */
	function uninstall() {
		require('../schema/schema_uninstall.inc');
		$pre=Database::getPrefix();
		foreach($uninstallqueries as $q) Database::query(sprintf($q,$pre));
	}
	
        /**
         * Scans the installed modules for API methods.
         * 
         * @return mixed[] 
         */
	private function scanModules() {
		chdir('../modules');
		$methods=array();
		$modules=Registry::getModuleNames();
		$ignore=array('__construct','loadModuleClass','getModuleName');
		foreach($modules as $m) {
			$methods[$m]=array();
			$list=scandir(Registry::location($m));
			$classes=array();
			foreach($list as $l) if(preg_match('/^[A-Z][a-zA-Z]*[.]php*$/',$l)==1) array_push($classes,$l);
			foreach($classes as $c) {
				require_once(Registry::location($m).DIRECTORY_SEPARATOR.$c);
				$class=substr($c,0,-4);
				$methods[$m][$class]=array();
				$meth=get_class_methods($class);
				foreach($meth as $x) if(!in_array($x,$ignore)) array_push($methods[$m][$class],$x);
			}
		}
		chdir('../core');
		return $methods;
	}
}

?>
