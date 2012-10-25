<?php

//Implicit event types.
$events=array(
	"profile"=>array('joinednetwork','leftnetwork','updatedprofile'),
	"user-relations"=>array('sentfriendrequest','acceptedrequest'),
	"pub-sub"=>array('creatednewpost'),
	"groups"=>array('creatednewgroup','joinedgroup','leftgroup','becamemoderator'),
	"messaging"=>array('sentmessage')
);

?>
