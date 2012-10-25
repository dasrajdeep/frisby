<?php

//Database queries for schema tables installation.
$tables=array(
	'accounts'=>"create table %saccounts (
		acc_no int not null auto_increment,
		email varchar(150) not null,
		firstname varchar(100) not null,
		middlename varchar(100) default '',
		lastname varchar(100) default '',
		status tinyint default 0,
		primary key (acc_no)
	) engine=INNODB",
	'images'=>"create table %simages (
		img_id int not null auto_increment,
		type varchar(100) not null,
		height int,
		width int,
		bits tinyint,
		imgdata longblob not null,
		primary key (img_id)
	) engine=INNODB",
	'profile'=>"create table %sprofile (
		acc_no int not null,
		avatar int default 1,
		alias varchar(50),
		sex varchar(10),
		dob date,
		location varchar(100),
		primary key (acc_no),
		foreign key (acc_no) references %saccounts (acc_no) on update cascade on delete cascade,
		foreign key (avatar) references %simages (img_id) on update cascade on delete cascade
	) engine=INNODB",
	'privacy'=>"create table %sprivacy (
		acc_no int not null,
		infofield varchar(50) not null,
		restriction tinyint default 0,
		primary key (acc_no,infofield),
		foreign key (acc_no) references %saccounts(acc_no) on update cascade on delete cascade
	) engine=INNODB",
	'user_relations'=>"create table %suser_relations (
		user1 int,
		user2 int,
		type tinyint default 0,
		status int default 0,
		primary key (user1,user2),
		foreign key (user1) references %saccounts(acc_no) on update cascade on delete cascade,
		foreign key (user2) references %saccounts(acc_no) on update cascade on delete cascade
	) engine=INNODB",
	'groups'=>"create table %sgroups (
		group_id int not null auto_increment,
		name varchar(150) not null,
		description text,
		type tinyint default 0,
		creationdate date,
		primary key (group_id),
		unique (name)
	) engine=INNODB",
	'nodes'=>"create table %snodes (
		node_id int not null auto_increment,
		type tinyint not null,
		ref_id int not null,
		primary key (node_id),
		unique (type,ref_id)
	) engine=INNODB",
	'mime'=>"create table %smime (
		mime_id int not null auto_increment,
		type tinyint not null,
		ref_id int not null,
		primary key (mime_id),
		unique (type,ref_id)
	) engine=INNODB",
	'posts'=>"create table %sposts (
		post_id int not null auto_increment,
		publisher int,
		textdata text,
		timestamp timestamp default CURRENT_TIMESTAMP,
		thread int default 0,
		node int not null,
		mime int default 0,
		primary key (post_id),
		foreign key (publisher) references %saccounts(acc_no) on update cascade on delete cascade,
		foreign key (node) references %snodes(node_id) on update cascade on delete cascade,
		foreign key (mime) references %smime(mime_id) on update cascade on delete cascade
	) engine=INNODB",
	'group_members'=>"create table %sgroup_members (
		member_id int,
		group_id int,
		type tinyint default 0,
		joindate date,
		primary key (member_id,group_id),
		foreign key (member_id) references %saccounts(acc_no) on update cascade on delete cascade,
		foreign key (group_id) references %sgroups(group_id) on update cascade on delete cascade
	) engine=INNODB",
	'messages'=>"create table %smessages (
		msg_id int not null auto_increment,
		sender int not null,
		receiver int not null,
		status tinyint default 0,
		textdata text,
		timestamp timestamp default CURRENT_TIMESTAMP,
		primary key (msg_id),
		foreign key (sender) references %saccounts(acc_no) on update cascade on delete cascade,
		foreign key (receiver) references %saccounts(acc_no) on update cascade on delete cascade
	) engine=INNODB",
	'events'=>"create table %sevents (
		event_id int not null auto_increment,
		category varchar(20) not null,
		event_name varchar(50) not null,
		description text,
		primary key (event_id),
		unique (event_name)
	) engine=INNODB",
	'event_log'=>"create table %sevent_log (
		log_id int not null auto_increment,
		event int not null,
		timestamp timestamp default CURRENT_TIMESTAMP,
		description text,
		origin int not null,
		target int,
		status tinyint default 0,
		primary key (log_id),
		foreign key (event) references %sevents(event_id) on update cascade on delete cascade,
		foreign key (origin) references %saccounts(acc_no) on update cascade on delete cascade
	) engine=INNODB",
	'extensions'=>"create table %sextensions (
		ext_id int not null auto_increment,
		type tinyint not null,
		table_name varchar(25) not null,
		primary key (ext_id),
		unique (table_name),
		unique (type)
	) engine=INNODB"
);

?>
