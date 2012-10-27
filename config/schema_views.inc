<?php

//Contains the views required by the engine.
$views=array(
	'view_profile'=>
	"create or replace view %sview_profile as
		select 
		a.acc_no as `acc_no`,a.firstname as `firstname`,a.middlename as `middlename`,a.lastname as `lastname`,a.email as `email`,
		p.alias as `alias`,p.sex as `sex`,p.dob as `dob`,p.location as `location`,i.imgdata as `avatar`
		from 
		%saccounts as a inner join %sprofile as p inner join %simages as i
		on
	a.acc_no=p.acc_no and p.avatar=i.img_id"
);

?>
