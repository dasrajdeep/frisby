<?php
/**
 * This file contains the boostrap loader for the engine.
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
namespace frisby;

date_default_timezone_set('Asia/Kolkata');

error_reporting(E_ALL);
//ini_set('display_errors', false);

$config=parse_ini_file('../frisby.ini',true);
$GLOBALS['config']=$config;

require_once('./Logger.php');
require_once('./error-handlers.php');
require_once('./EventHandler.php');
require_once('./Database.php');
require_once('./Registry.php');
require_once('./ModuleSupport.php');

set_error_handler('frisby\bootHandler');

Logger::init();
Database::connect();
Registry::init();

set_error_handler('frisby\defaultHandler');

register_shutdown_function('frisby\shutdown');

/**
 * Performs housekeeping at script termination. 
 */
function shutdown() {
	Database::disconnect();
	Logger::shutdown();
}

?>
