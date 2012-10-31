<?php

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
