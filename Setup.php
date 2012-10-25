<?php

class Setup {
	
	//Checks the current setup.
	function checkSetup() {
		require('config/schema_tables.inc');
		$keys=array_keys($tables);
		foreach($keys as $t) Database::get($t,'*',false);
		if(ErrorHandler::hasErrors()) return false;
		else return true;
	}
	
	//Runs the setup and configures the engine. Cleans and installs.
	function run() {
		ErrorHandler::reset();
		$this->uninstallDB();
		$this->installDB();
	}
	
	//A complete installation of the database.
	function installDB() {
		$this->installDBSchema();
		$this->installDBTriggers();
		$this->installData();
	}
	
	//Install database schema.
	function installDBSchema() {
		$pre=Database::getPrefix();
		require('config/schema_tables.inc');
		foreach($tables as $q) Database::query(str_replace('%s',$pre,$q));
	}
	
	//Install default data.
	private function installData() {
		require('config/schema_data.inc');
		$keys=array_keys($events);
		foreach($keys as $k) {
			foreach($events[$k] as $x) Database::add('events',array('category','event_name'),array($k,$x));
		}
		$imgsrc='data/default_avatar.jpg';
		$iminfo=getimagesize($imgsrc);
		$img=addslashes(file_get_contents($imgsrc));
		Database::query(sprintf("insert into %simages (type,imgdata,width,height,bits) values ('%s','%s',%s,%s,%s)",Database::getPrefix(),$iminfo['mime'],$img,$iminfo[0],$iminfo[1],$iminfo['bits']));
	}
	
	//Install database triggers.
	function installDBTriggers() {
		require('config/schema_triggers.inc');
		$pre=Database::getPrefix();
		foreach($triggers as $q) Database::query(str_replace('%s',$pre,$q));
	}
	
	//Uninstall database schema.
	function uninstallDB() {
		$ext=Database::get('extensions','table_name',false);
		foreach($ext as $e) Database::query(sprintf("drop table if exists %mime_%s",Database::getPrefix(),$e['table_name']));
		require('config/schema_uninstall.inc');
		$pre=Database::getPrefix();
		foreach($uninstallqueries as $q) Database::query(sprintf($q,$pre));
	}
	
}

?>
