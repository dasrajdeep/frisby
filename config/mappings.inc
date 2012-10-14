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
	$map['getpriv']=array('Privacy','getPrivacy');
	
	//The routes for the modules.
	$routes['Profile']='profiling/controller.php';
	$routes['UserRelations']='user-relations/controller.php';

?>
