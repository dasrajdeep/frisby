<?php

ini_set('display_errors', false);

require_once('Logger.php');
require_once('ErrorHandler.php');
require_once('Database.php');
require_once('Registry.php');
require_once('ModuleSupport.php');

Logger::init();
Database::connect();
Registry::init();

set_error_handler('errorHandler');
register_shutdown_function('shutdown');

function shutdown() {
	Database::disconnect();
	Logger::shutdown();
}

function errorHandler($level,$message,$filename,$line) {
        $levels=array(1=>'FATAL',2=>'WARNING',4=>'PARSE',8=>'NOTICE');
        if($level<10) $level=$levels[$level];
        $error='**'.$level.'** '.$message.' (at file: '.$filename.', line '.$line.')';
        ErrorHandler::fire('php', $error);
	throw new Exception('Frisby Exception');
	die();
}

?>
