<?php
	//This section contains the mappings from the method names to the actual methods.
	
	//The map array.
	$map=array();
	
	//The routes array.
	$routes=array();
	
	//The mappings for profile.
	$map['createaccount']=array('Profile','createAccount');
	$map['deleteaccount']=array('Profile','deleteAccount');
	$map['setuserid']=array('Profile','setUserID');
	$map['createprofile']=array('Profile','createProfile');
	$map['setavatar']=array('Profile','setAvatar');
	$map['deleteprofile']=array('Profile','deleteProfile');
	$map['updateprofile']=array('Profile','updateProfile');
	$map['fetchprofile']=array('Profile','fetchProfile');
	$map['setprivacy']=array('Profile','setPrivacy');
	$map['getprivacy']=array('Profile','getPrivacy');
	
	//The mappings for user-relations.
	$map['friendrequest']=array('UserRelations','createRelation');
	$map['friendaccept']=array('UserRelations','confirmRelation');
	
	//The mappings for publish-subscribe.
	$map['createpost']=array('PubSub','createPost');
	$map['deletepost']=array('PubSub','deletePost');
	$map['fetchposts']=array('PubSub','fetchPosts');
	$map['getpost']=array('PubSub','getPost');
	
	//The mappings for groupings.
	$map['creategroup']=array('Grouping','createGroup');
	$map['deletegroup']=array('Grouping','deleteGroup');
	$map['updategroup']=array('Grouping','updateGroup');
	$map['addmember']=array('Grouping','addMember');
	$map['deletemember']=array('Grouping','deleteMember');
	$map['updateprivilege']=array('Grouping','updatePrivilege');
	
	//The mappings for messaging.
	$map['sendmessage']=array('Messaging','sendMessage');
	$map['savedraft']=array('Messaging','saveDraft');
	$map['editdraft']=array('Messaging','editDraft');
	$map['senddraft']=array('Messaging','sendDraft');
	$map['fetchoutbox']=array('Messaging','fetchOutbox');
	$map['deleteoutbox']=array('Messaging','deleteOutboxMessages');
	$map['fetchinbox']=array('Messaging','fetchInbox');
	$map['fetchunread']=array('Messaging','fetchUnread');
	$map['markread']=array('Messaging','markRead');
	$map['deleteinbox']=array('Messaging','deleteInboxMessages');
	
	//The mappings for search.
	$map['search']=array('Search','search');
	$map['searchpeople']=array('Search','searchPeople');
	$map['searchmembers']=array('Search','searchMembers');
	$map['searchgroup']=array('Search','searchGroup');
	$map['searchposts']=array('Search','searchPosts');
	
	//The routes for the modules.
	$routes['Profile']='profiling';
	$routes['UserRelations']='user-relations';
	$routes['PubSub']='pubsub';
	$routes['Grouping']='grouping';
	$routes['Messaging']='messaging';
	$routes['Search']='search';

?>
