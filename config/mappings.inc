<?php
	//This section contains the mappings from the method names to the actual methods.
	
	//The map array.
	$map=array();
	
	//The routes array.
	$routes=array();
	
	//The mappings.
	$map['createacc']=array('Profile','createAccount');
	$map['deleteacc']=array('Profile','deleteAccount');
	$map['setuid']=array('Profile','setUserID');
	$map['createprof']=array('Profile','createProfile');
	$map['deleteprof']=array('Profile','deleteProfile');
	$map['updateprof']=array('Profile','updateProfile');
	$map['fetchprof']=array('Profile','fetchProfile');
	$map['setpriv']=array('Profile','setPrivacy');
	$map['getpriv']=array('Profile','getPrivacy');
	
	$map['frndreq']=array('UserRelations','createRelation');
	$map['frndaccpt']=array('UserRelations','confirmRelation');
	
	$map['createpost']=array('PubSub','createPost');
	$map['deletepost']=array('PubSub','deletePost');
	$map['fetchposts']=array('PubSub','fetchPosts');
	$map['getpost']=array('PubSub','getPost');
	
	$map['creategrp']=array('Grouping','createGroup');
	$map['deletegrp']=array('Grouping','deleteGroup');
	$map['updategrp']=array('Grouping','updateGroup');
	$map['addmem']=array('Grouping','addMember');
	$map['deletemem']=array('Grouping','deleteMember');
	$map['mempriv']=array('Grouping','updatePrivilege');
	
	$map['sendmsg']=array('Messaging','sendMessage');
	$map['savedraft']=array('Messaging','saveDraft');
	$map['fwdmsg']=array('Messaging','forwardMessage');
	$map['fetchoutbox']=array('Messaging','fetchOutbox');
	$map['deleteoutmsg']=array('Messaging','deleteOutboxMessages');
	$map['fetchinbox']=array('Messaging','fetchInbox');
	$map['fetchunread']=array('Messaging','fetchUnread');
	$map['markread']=array('Messaging','markRead');
	$map['deletinmsg']=array('Messaging','deleteInboxMessages');
	
	$map['search']=array('Search','search');
	$map['searchpeople']=array('Search','searchPeople');
	$map['searchmem']=array('Search','searchMembers');
	$map['searchgrp']=array('Search','searchGroup');
	$map['searchallposts']=array('Search','searchAllPosts');
	$map['searchnodeposts']=array('Search','searchNode');
	
	//The routes for the modules.
	$routes['Profile']='profiling/controller.php';
	$routes['UserRelations']='user-relations/controller.php';
	$routes['Pubsub']='pubsub/controller.php';

?>
