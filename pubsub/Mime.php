<?php

class Mime {
	//Reference to the calling controller.
	private $ctrl=null;
	
	//Stores the reference to the caller.
	function __construct($ref) {
		$this->ctrl=$ref;
	}
	
	//Creates a new MIME relation schema.
	function createMimeSchema($name,$type) {
		ErrorHandler::reset();
		Database::query(sprint("create table %smime_%s (
			id int not null auto_increment,
			name varchar(100),
			ref_id varchar(150) not null,
			primary key(id)
		) engine=INNODB",Database::getPrefix(),$name));
		Database::add('extensions',array('type','table_name'),array($type,$name));
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		else return array(true,null);
	}
	
	function deleteMimeSchema($name) {
		ErrorHandler::reset();
		Database::query(sprintf("drop table if exists %smime_%s",Database::getPrefix(),$name));
		Database::remove('extensions',sprintf("table_name='%s'",$name));
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		else return array(true,null);
	}
}

?>
