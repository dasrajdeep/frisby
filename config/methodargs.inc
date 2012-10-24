<?php
	//This section contains the valid mappings of method names with their argument lists.
	
	//An array containing method names with their number and type of signatures.
	$sig=array();
	
	//The method signatures defined.
	$sig['createAccount']=array(0,2,array(0,0));
	$sig['deleteAccount']=array(1,1,array(0));
	$sig['updateAccount']=array(2,2,array(0,2));
	$sig['createProfile']=array(2,2,array(0,2));
	$sig['setAvatar']=array(2,2,array(0,1));
	$sig['deleteProfile']=array(1,1,array(0));
	$sig['updateProfile']=array(2,2,array(0,2));
	$sig['fetchProfile']=array(1,2,array(0,2));
	$sig['setPrivacy']=array(2,2,array(0,2));
	$sig['getPrivacy']=array(1,2,array(0,2));
	
	$sig['createRelation']=array(2,3,array(0,0,0));
	$sig['confirmRelation']=array(2,2,array(0,0));
	
	$sig['createPost']=array(5,6,array(0,0,0,0,2,0));
	$sig['deletePost']=array(1,1,array(0));
	$sig['fetchPosts']=array(3,3,array(0,0,0));
	$sig['getPost']=array(1,1,array(0));
	
	$sig['createGroup']=array(3,4,array(0,1,1,0));
	$sig['deleteGroup']=array(1,1,array(0));
	$sig['updateGroup']=array(2,2,array(0,2));
	$sig['addMember']=array(2,3,array(0,0,0));
	$sig['deleteMember']=array(2,2,array(0,2));
	$sig['updatePrivilege']=array(3,3,array(0,0,0));
	
	$sig['sendMessage']=array(3,3,array(0,0,1));
	$sig['saveDraft']=array(3,3,array(0,0,1));
	$sig['editDraft']=array(2,2,array(0,1));
	$sig['sendDraft']=array(1,1,array(0));
	$sig['fetchInbox']=array(1,1,array(0));
	$sig['fetchUnread']=array(1,1,array(0));
	$sig['markRead']=array(1,1,array(2));
	$sig['deleteInboxMessages']=array(1,2,array(2,0));
	$sig['fetchOutbox']=array(1,1,array(0));
	$sig['deleteOutboxMessages']=array(1,2,array(2,0));
	
	$sig['searchPeople']=array(1,1,array(2));
	$sig['searchMembers']=array(2,2,array(2,2));
	$sig['searchGroup']=array(1,1,array(2));
	$sig['searchPosts']=array(1,1,array(2));
	$sig['search']=array(2,2,array(1,2));
?>
