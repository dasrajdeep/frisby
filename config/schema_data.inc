<?php

//Implicit event types.
$events=array(
	array('joinednetwork','profile','user joined the social network'),
	array('leftnetwork','profile','user left the social network'),
	array('updatedprofile','profile','user updated profile'),
	array('sentfriendrequest','user-relations','user sent a friend request to another user'),
	array('acceptedrequest','user-relations','user accepted friend request from another user'),
	array('creatednewpost','pub-sub','user posted on a node'),
	array('creatednewgroup','groups','user created a new group'),
	array('joinedgroup','groups','user joined a group'),
	array('leftgroup','groups','user left a group'),
	array('becamemoderator','groups','user became a moderator of a group'),
	array('sentmessage','messaging','user sent a message to another user')
);

?>
