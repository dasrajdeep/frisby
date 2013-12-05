<?php
/**
 * This file contains the relation schema queries for the engine.
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
 
//Database queries for schema tables installation.
$tables=array(
	'registry'=>"create table %sregistry (
		method varchar(50) not null,
		classname varchar(50) not null,
		module varchar(50),
		type tinyint default 0,
		primary key (method)
	) engine=INNODB",
	'accounts'=>"create table %saccounts (
		acc_no int not null auto_increment,
		email varchar(150) not null,
		password varchar(250),
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
		image mediumblob not null,
		thumb blob,
		primary key (img_id)
	) engine=INNODB",
	'profile'=>"create table %sprofile (
		acc_no int not null,
		avatar int default 1,
		alias varchar(50),
		sex enum('male','female'),
		dob date,
		location varchar(100),
		primary key (acc_no),
		foreign key (acc_no) references %saccounts (acc_no) on update cascade on delete cascade,
		foreign key (avatar) references %simages (img_id) on update cascade on delete restrict
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
		foreign key (member_id) references %saccounts(acc_no) on update cascade on delete cascade
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
		origin int not null,
		target int,
		primary key (log_id),
		foreign key (event) references %sevents(event_id) on update cascade on delete cascade,
		foreign key (origin) references %saccounts(acc_no) on update cascade on delete cascade
	) engine=INNODB",
	'external'=>"create table %sexternal (
		ext_id int not null auto_increment,
		type tinyint not null,
		resource_name text,
		resource_id varchar(150) not null,
		primary key (ext_id)
	) engine=INNODB",
	'poll_log'=>"create table %spoll_log (
		acc_no int not null,
		last_hit timestamp,
		status tinyint default 0,
		primary key (acc_no),
		foreign key (acc_no) references %saccounts(acc_no) on update cascade on delete cascade
	) engine=INNODB"
);

?>
