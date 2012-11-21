<?php
/**
 * This file contains the schema views installation queries for the engine.
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
 
//Contains the views required by the engine.
$views=array(
	'view_profile'=>
	"create or replace view %sview_profile as
		select 
		a.firstname as `firstname`,a.middlename as `middlename`,a.lastname as `lastname`,a.email as `email`,
		p.*,
		i.imgdata as `avatarimage`,i.type as `imgtype`
		from 
		%saccounts as a inner join %sprofile as p inner join %simages as i
		on
	a.acc_no=p.acc_no and p.avatar=i.img_id",
	'view_posts'=>
	"create or replace view %sview_posts as
		select
		post_id,publisher as pub_id,concat(firstname,' ',middlename,' ',lastname) as publisher,textdata,timestamp,thread,node,avatarimage,imgtype
		from
		%sview_profile inner join %sposts
		on 
	acc_no=publisher",
	'view_events'=>
	"create or replace view %sview_events as
		select
		log_id,acc_no,concat(firstname,' ',middlename,' ',lastname) as name,event_name,description,category,timestamp,avatarimage,imgtype
		from
		%sevents inner join %sevent_log inner join %sview_profile
		on
	event_id=event and origin=acc_no"
);

?>
