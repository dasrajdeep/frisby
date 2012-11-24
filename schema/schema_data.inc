<?php
/**
 * This file contains the default data for the engine.
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
 
//Implicit event types.
$events=array(
	array('joinednetwork','Profile','user joined the social network'),
	array('leftnetwork','Profile','user left the social network'),
	array('updatedprofile','Profile','user updated profile'),
	array('sentfriendrequest','UserRelations','user sent a friend request to another user'),
	array('acceptedrequest','UserRelations','user accepted friend request from another user'),
	array('creatednewpost','PubSub','user posted on a node'),
	array('creatednewgroup','Grouping','user created a new group'),
	array('joinedgroup','Grouping','user joined a group'),
	array('leftgroup','Grouping','user left a group'),
	array('becamemoderator','Grouping','user became a moderator of a group'),
	array('sentmessage','Messaging','user sent a message to another user')
);

?>
