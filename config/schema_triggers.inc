<?php

//Database triggers to preserve consistency and integrity of information.
$triggers=array(
	"create trigger %strg_a before insert on %sgroups for each row begin set new.creationdate=CURDATE(); end",
	"create trigger %strg_b before insert on %sgroup_members for each row begin set new.joindate=CURDATE(); end",
	"create trigger %strg_c before insert on %saccounts
	 for each row begin
		if new.`firstname` not regexp '^[a-zA-Z]*[a-zA-Z]*$' then set new.firstname=null; end if;
		if new.`lastname` not regexp '^[a-zA-Z]*[a-zA-Z]*$' then set new.firstname=null; end if;
		if new.`middlename` not regexp '^[a-zA-Z]*[a-zA-Z]*$' then set new.firstname=null; end if;
		if new.email not regexp '^[a-zA-Z0-9][a-zA-Z0-9._-]*[a-zA-Z0-9]@[a-zA-Z0-9][a-zA-Z0-9._-]*[a-zA-Z0-9]\.[a-zA-Z]{2,4}$' then set new.email=null; end if;
	end",
	"create trigger %strg_d before insert on %sprofile
	 for each row begin
		if new.`alias` not regexp '^[a-zA-Z0-9]*[a-zA-Z0-9]*$' then set new.acc_no=null; end if;
		if new.sex not regexp '^male$|^female$' then set new.acc_no=null; end if;
		if new.`location` not regexp '^[a-zA-Z]*[a-zA-Z]*$' then set new.acc_no=null; end if;
	 end",
	 "create trigger %strg_e after delete on %saccounts
	  for each row begin
		delete from %sprofile where acc_no=old.acc_no;
	 end",
	 "create trigger %strg_f after delete on %sprofile
	  for each row begin
		delete from %simages where img_id=old.avatar and old.avatar>1;
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
	 end",
	 "create trigger %strg_j after insert on %sgroups
	  for each row begin
	  insert into %snodes (type,ref_id) values (1,new.group_id);
	 end"
);

?>
