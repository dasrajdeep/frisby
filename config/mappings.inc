<?php
	//This section contains the mappings from the method names to the actual methods.
	
	//The map array.
	$map=array();
	
	//The routes array.
	$routes=array();
	
	//The mappings for events.
	$map['registerevent']=array('Events','registerEvent');
	$map['unregisterevent']=array('Events','unregisterEvent');
	$map['fetchnames']=array('Events','fetchNames');
	$map['fetchcategories']=array('Events','fetchCategories');
	$map['fireevent']=array('Events','fireEvent');
	$map['updateeventstatus']=array('Events','updateStatus');
	$map['fetcheventsbycategory']=array('Events','fetchEventsByCategory');
	$map['fetcheventsbyentity']=array('Events','fetchEventsByEntity');
	
	//The mappings for profile.
	$map['createaccount']=array('Profile','createAccount');
	$map['deleteaccount']=array('Profile','deleteAccount');
	$map['updateaccount']=array('Profile','updateAccount');
	$map['fetchaccountinfo']=array('Profile','fetchAccountInfo');
	$map['createprofile']=array('Profile','createProfile');
	$map['setavatar']=array('Profile','setAvatar');
	$map['deleteprofile']=array('Profile','deleteProfile');
	$map['updateprofile']=array('Profile','updateProfile');
	$map['fetchprofile']=array('Profile','fetchProfile');
	$map['setprivacy']=array('Profile','setPrivacy');
	$map['getprivacy']=array('Profile','getPrivacy');
	$map['registerprofileattribute']=array('Profile','registerProfileAttribute');
	$map['unregisterprofileattribute']=array('Profile','unregisterProfileAttribute');
	$map['getattributenames']=array('Profile','getAttributeNames');
	
	//The mappings for user-relations.
	$map['friendrequest']=array('UserRelations','createRelation');
	$map['friendaccept']=array('UserRelations','confirmRelation');
	$map['changerelation']=array('UserRelations','updateRelation');
	$map['fetchrelationinfo']=array('UserRelations','fetchRelationInfo');
	
	//The mappings for publish-subscribe.
	$map['createpost']=array('PubSub','createPost');
	$map['deletepost']=array('PubSub','deletePost');
	$map['fetchposts']=array('PubSub','fetchPosts');
	$map['getpost']=array('PubSub','getPost');
	$map['createmimeschema']=array('PubSub','createMimeSchema');
	$map['deletemimeschema']=array('PubSub','deleteMimeSchema');
	$map['fetchschemas']=array('PubSub','fetchSchemas');
	
	//The mappings for groupings.
	$map['creategroup']=array('Grouping','createGroup');
	$map['deletegroup']=array('Grouping','deleteGroup');
	$map['updategroup']=array('Grouping','updateGroup');
	$map['fetchgroup']=array('Grouping','fetchGroup');
	$map['addmember']=array('Grouping','addMember');
	$map['deletemember']=array('Grouping','deleteMember');
	$map['updateprivilege']=array('Grouping','updatePrivilege');
	$map['fetchmembers']=array('Grouping','fetchMembers');
	
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
	$map['searchgroups']=array('Search','searchGroup');
	$map['searchposts']=array('Search','searchPosts');
	
	//The routes for the modules.
	$routes['Profile']='profiling';
	$routes['UserRelations']='user-relations';
	$routes['PubSub']='pubsub';
	$routes['Grouping']='grouping';
	$routes['Messaging']='messaging';
	$routes['Search']='search';
	$routes['Events']='events';

?>
