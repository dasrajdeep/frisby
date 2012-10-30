<?php

//Database queries for schema uninstallation.
$uninstallqueries=array(
	"drop table if exists %sregistry",
	"drop table if exists %sprivacy",
	"drop table if exists %sprofile",
	"drop table if exists %suser_relations",
	"drop table if exists %sposts",
	"drop table if exists %snodes",
	"drop table if exists %smime",
	"drop table if exists %sgroup_members",
	"drop table if exists %smessages",
	"drop table if exists %sevent_log",
	"drop table if exists %sevents",
	"drop table if exists %simages",
	"drop table if exists %sgroups",
	"drop table if exists %saccounts",
	"drop table if exists %sextensions",
        "drop view if exists %sview_profile",
	"drop trigger if exists %strg_a",
	"drop trigger if exists %strg_b",
	"drop trigger if exists %strg_c",
	"drop trigger if exists %strg_d",
	"drop trigger if exists %strg_e",
	"drop trigger if exists %strg_f",
	"drop trigger if exists %strg_g",
	"drop trigger if exists %strg_h",
	"drop trigger if exists %strg_i",
	"drop trigger if exists %strg_j"
);

?>
