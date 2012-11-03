<?php
/**
 * This file contains the database configurations for the engine.
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
	
//The database configuration array.
$database=array();

//The hostname of the MySQL DBMS.
$database['host']='localhost';

//The database username.
$database['username']='root';

//The password for the database.
$database['password']='';

//The name of the database to be used. Note that this is not the name of the DBMS.
$database['name']='socio';

//A prefix generally used to distinguish the tables used in the database. This is optional.
$database['prefix']='socio_';

?>
