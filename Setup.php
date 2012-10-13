<?php

class Setup {
	//Database queries for schema setup.
	private $queries=array(
		"create table %saccounts (acc_no int not null auto_increment,acc_id text,primary key (acc_no))",
		"create table %sprofile (acc_no int not null,firstname text,middlename text,lastname text,alias text,email text,sex varchar(10),dob date,location text,primary key (acc_no))",
		"create table %sprivacy (acc_no int,infofield text,restriction tinyint)",
		"create table %suser_relations (user1 int,user2 int,type tinyint,status int)",
		"create table %sgroups (group_id int not null auto_increment,name varchar(200) not null,description text,creationdate date,primary key (group_id),unique (name))",
		"create table %sposts (post_id int not null auto_increment,publisher int,textdata text,timestamp bigint,type tinyint,node int,primary key (post_id))",
		"create table %sgroup_members (member_id int,group_id int,type tinyint,joindate date)",
		"create table %smessages (msg_id int not null auto_increment,sender int,receiver int,textdata text,timestamp bigint,primary key (msg_id))",
		"create table %sevents (event_id int not null auto_increment,type tinyint,timestamp bigint,description text,origin int,target int,primary key (event_id))",
		"create table %saudit (audit_id int not null auto_increment,type tinyint,source int,ref_id int,primary key (audit_id))"
	);
	
	//Checks the current setup.
	function checkSetup() {
		Database::get('accounts','*',false);
		if(ErrorHandler::hasErrors()) return false;
		else return true;
	}
	
	//Runs the setup and configures the engine.
	function run() {
		ErrorHandler::reset();
		$this->setupDBSchema();
	}
	
	//Setup database schema.
	function setupDBSchema() {
		$pre=Database::getPrefix();
		foreach($this->queries as $q) {
			Database::query(sprintf($q,$pre));
			if(ErrorHandler::hasErrors()) break;
		}
	}
	
}

?>
