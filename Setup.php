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
	
	//Database queries for schema installation.
	private $schemaqueries=array(
		"create table %saccounts (
			acc_no int not null auto_increment,
			acc_id text,
			status tinyint default 0,
			primary key (acc_no)
		) engine=INNODB",
		"create table %simages (
			img_id int not null auto_increment,
			type varchar(100),
			height int,
			width int,
			bits tinyint,
			imgdata longblob not null,
			primary key (img_id)
		) engine=INNODB",
		"create table %sprofile (
			acc_no int not null,
			avatar int default 1,
			firstname text default '',
			middlename text default '',
			lastname text default '',
			alias text,
			email text,
			sex varchar(10),
			dob date,
			location text,
			primary key (acc_no),
			foreign key (acc_no) references %saccounts (acc_no) on update cascade on delete cascade,
			foreign key (avatar) references %simages (img_id) on update cascade on delete cascade
		) engine=INNODB",
		"create table %sprivacy (
			acc_no int,
			infofield varchar(50),
			restriction tinyint default 0,
			primary key (acc_no,infofield),
			foreign key (acc_no) references %saccounts(acc_no) on update cascade on delete cascade
		) engine=INNODB",
		"create table %suser_relations (
			user1 int,
			user2 int,
			type tinyint default 0,
			status int default 0,
			primary key (user1,user2),
			foreign key (user1) references %saccounts(acc_no) on update cascade on delete cascade,
			foreign key (user2) references %saccounts(acc_no) on update cascade on delete cascade
		) engine=INNODB",
		"create table %sgroups (
			group_id int not null auto_increment,
			name varchar(200) not null,
			description text,
			type tinyint default 0,
			creationdate date,
			primary key (group_id),
			unique (name)
		) engine=INNODB",
		"create table %sposts (
			post_id int not null auto_increment,
			publisher int,
			textdata text,
			timestamp timestamp default CURRENT_TIMESTAMP,
			thread int default 0,
			type tinyint default 0,
			node int not null,
			nodetype tinyint not null,
			mime int,
			mime_type tinyint default 0,
			primary key (post_id),
			foreign key (publisher) references %saccounts(acc_no) on update cascade on delete cascade
		) engine=INNODB",
		"create table %sgroup_members (
			member_id int,
			group_id int,
			type tinyint default 0,
			joindate date,
			primary key (member_id,group_id),
			foreign key (member_id) references %saccounts(acc_no) on update cascade on delete cascade,
			foreign key (group_id) references %sgroups(group_id) on update cascade on delete cascade
		) engine=INNODB",
		"create table %smessages (
			msg_id int not null auto_increment,
			sender int,
			receiver int,
			status tinyint default 0,
			textdata text,
			timestamp timestamp default CURRENT_TIMESTAMP,
			primary key (msg_id),
			foreign key (sender) references %saccounts(acc_no) on update cascade on delete cascade,
			foreign key (receiver) references %saccounts(acc_no) on update cascade on delete cascade
		) engine=INNODB",
		"create table %sevents (
			event_id int not null auto_increment,
			type tinyint not null,
			timestamp timestamp default CURRENT_TIMESTAMP,
			description text,
			origin int not null,
			target int,
			primary key (event_id)
		) engine=INNODB"
	);
	
	//Database triggers to preserve consistency of information.
	private $triggers=array(
		"create trigger %strg_a before insert on %sgroups for each row begin set new.creationdate=CURDATE(); end",
		"create trigger %strg_b before insert on %sgroup_members for each row begin set new.joindate=CURDATE(); end",
		"create trigger %strg_c before insert on %sprofile
		 for each row begin
			if new.`firstname` not regexp '^[a-zA-Z]*[a-zA-Z]*$' then set new.acc_no=null; end if;
			if new.`lastname` not regexp '^[a-zA-Z]*[a-zA-Z]*$' then set new.acc_no=null; end if;
			if new.`middlename` not regexp '^[a-zA-Z]*[a-zA-Z]*$' then set new.acc_no=null; end if;
			if new.`alias` not regexp '^[a-zA-Z0-9]*[a-zA-Z0-9]*$' then set new.acc_no=null; end if;
			if new.email not regexp '^[a-zA-Z0-9][a-zA-Z0-9._-]*[a-zA-Z0-9]@[a-zA-Z0-9][a-zA-Z0-9._-]*[a-zA-Z0-9]\.[a-zA-Z]{2,4}$' then set new.acc_no=null; end if;
			if new.sex not regexp '^male$|^female$' then set new.acc_no=null; end if;
			if new.`location` not regexp '^[a-zA-Z]*[a-zA-Z]*$' then set new.acc_no=null; end if;
		 end",
		"create trigger %strg_d before insert on %sposts
		 for each row begin
			declare flag Integer;
			if new.`nodetype`=0 then
				select count(`acc_no`) into @flag from %saccounts where `acc_no`=new.node;
				if @flag=0 then set new.node=null; end if;
			elseif new.`nodetype`=1 then
				select count(`group_id`) into @flag from %sgroups where `group_id`=new.node;
				if @flag=0 then set new.node=null; end if;
			end if;
			if new.mime_type=0 then set new.mime=null;
			elseif new.mime_type=1 then
			select count(img_id) into @flag from %simages where img_id=new.mime;
			if @flag=0 then set new.node=null; end if;
			end if;
		 end",
		 "create trigger %strg_e after delete on %saccounts
		  for each row begin
			delete from %sprofile where acc_no=old.acc_no;
		 end",
		 "create trigger %strg_f after delete on %sprofile
		  for each row begin
			delete from %simages where img_id=old.avatar and old.avatar>1;
			delete from %sprivacy where acc_no=old.acc_no;
			delete from %suser_relations where (user1=old.acc_no or user2=old.acc_no);
			delete from %sposts where publisher=old.acc_no;
			delete from %smessages where (sender=old.acc_no or receiver=old.acc_no);
			delete from %sgroup_members where member_id=old.acc_no;
		 end",
		 "create trigger %strg_g before insert on %smessages
		  for each row begin
			if new.status not in (0,1) then set new.status=0; end if;
		 end",
		 "create trigger %strg_h before update on %smessages
		  for each row begin
			if new.status not in (0,1,3,5,7,9,11) then set new.status=old.status; end if;
		 end"
	);
	
	//Database queries for schema uninstallation.
	private $uninstallqueries=array(
		"drop table if exists %sprofile",
		"drop table if exists %sprivacy",
		"drop table if exists %suser_relations",
		"drop table if exists %sposts",
		"drop table if exists %sgroup_members",
		"drop table if exists %smessages",
		"drop table if exists %sevents",
		"drop table if exists %simages",
		"drop table if exists %sgroups",
		"drop table if exists %saccounts",
		"drop trigger if exists %strg_a",
		"drop trigger if exists %strg_b",
		"drop trigger if exists %strg_c",
		"drop trigger if exists %strg_d",
		"drop trigger if exists %strg_e",
		"drop trigger if exists %strg_f",
		"drop trigger if exists %strg_g",
		"drop trigger if exists %strg_h"
	);
	
	//Checks the current setup.
	function checkSetup() {
		foreach($this->tables as $t) Database::get($t,'*',false);
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
		$this->installAvatar();
	}
	
	//Install database schema.
	function installDBSchema() {
		$pre=Database::getPrefix();
		foreach($this->schemaqueries as $q) Database::query(str_replace('%s',$pre,$q));
	}
	
	//Install default avatar.
	private function installAvatar() {
		$imgsrc='data/default_avatar.jpg';
		$iminfo=getimagesize($imgsrc);
		$img=addslashes(file_get_contents($imgsrc));
		Database::query(sprintf("insert into %simages (type,imgdata,width,height,bits) values ('%s','%s',%s,%s,%s)",Database::getPrefix(),$iminfo['mime'],$img,$iminfo[0],$iminfo[1],$iminfo['bits']));
	}
	
	//Install database triggers.
	function installDBTriggers() {
		$pre=Database::getPrefix();
		foreach($this->triggers as $q) Database::query(str_replace('%s',$pre,$q));
	}
	
	//Uninstall database schema.
	function uninstallDB() {
		$pre=Database::getPrefix();
		foreach($this->uninstallqueries as $q) Database::query(sprintf($q,$pre));
	}
	
}

?>
