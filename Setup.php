<?php

class Setup {
	//List of tables in used by engine.
	private $tables=array(
		'accounts',
		'profile',
		'privacy',
		'user_relations',
		'groups',
		'posts',
		'group_members',
		'messages',
		'events',
		'images'
	);
	
	//Database queries for schema setup.
	private $queries=array(
		"create table %saccounts (acc_no int not null auto_increment,acc_id text,primary key (acc_no))",
		"create table %sprofile (acc_no int not null,avatar int,firstname text,middlename text,lastname text,alias text,email text,sex varchar(10),dob date,location text,primary key (acc_no))",
		"create table %sprivacy (acc_no int,infofield text,restriction tinyint)",
		"create table %suser_relations (user1 int,user2 int,type tinyint,status int)",
		"create table %sgroups (group_id int not null auto_increment,name varchar(200) not null,description text,creationdate date,primary key (group_id),unique (name))",
		"create table %sposts (post_id int not null auto_increment,publisher int,textdata text,timestamp bigint,type tinyint,node int,mime int,mime_type tinyint,primary key (post_id))",
		"create table %sgroup_members (member_id int,group_id int,type tinyint,joindate date)",
		"create table %smessages (msg_id int not null auto_increment,sender int,receiver int,textdata text,timestamp bigint,primary key (msg_id))",
		"create table %sevents (event_id int not null auto_increment,type tinyint,timestamp bigint,description text,origin int,target int,primary key (event_id))",
		"create table %simages (img_id int not null auto_increment,type varchar(100),size bigint,imgdata longblob,primary key (img_id))"
	);
	
	//Checks the current setup.
	function checkSetup() {
		foreach($this->tables as $t) Database::get($t,'*',false);
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
		foreach($this->queries as $q) Database::query(sprintf($q,$pre));
	}
	
}

?>
