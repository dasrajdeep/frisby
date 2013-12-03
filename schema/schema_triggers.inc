<?php
/**
 * This file contains the schema trigger installation queries for the engine.
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
 
//Database triggers to preserve consistency and integrity of information.
$triggers=array(
	"create trigger %strg_a before insert on %sgroups for each row begin set new.creationdate=CURDATE(); end",
	"create trigger %strg_b before insert on %sgroup_members for each row begin set new.joindate=CURDATE(); end",
	"create trigger %strg_c before insert on %saccounts
	 for each row begin
		if new.email not regexp '^[a-zA-Z0-9][a-zA-Z0-9._-]*[a-zA-Z0-9]@[a-zA-Z0-9][a-zA-Z0-9._-]*[a-zA-Z0-9]\.[a-zA-Z]{2,4}$' then set new.email=null; end if;
	end",
	"create trigger %strg_d before insert on %sprofile
	 for each row begin
		if new.`location` not regexp '^[a-zA-Z]*[a-zA-Z]*$' then set new.acc_no=null; end if;
	 end",
	 "create trigger %strg_e after delete on %sgroups
	  for each row begin
		delete from %snodes where type=1 and ref_id=old.group_id;
		delete from %sgroup_members where group_id=old.group_id;
	 end",
	 "create trigger %strg_f after delete on %sprofile
	  for each row begin
		delete from %simages where img_id=old.avatar and old.avatar>1;
		delete from %snodes where type=0 and ref_id=old.acc_no;
	 end",
	 "create trigger %strg_g before insert on %smessages
	  for each row begin
		if new.status not in (0,1) then set new.status=0; end if;
	 end",
	 "create trigger %strg_h before update on %smessages
	  for each row begin
		if new.status not in (0,1,3,5,7,9,11) then set new.status=old.status; end if;
	 end",
	 "create trigger %strg_i after insert on %sprofile
	  for each row begin
	  insert into %snodes (type,ref_id) values (0,new.acc_no);
	  insert into %spoll_log (acc_no) values (new.acc_no);
	 end",
	 "create trigger %strg_j after insert on %sgroups
	  for each row begin
	  insert into %snodes (type,ref_id) values (1,new.group_id);
	 end"
);

?>
