<?php
	
class Logger {
	//The logging file object.
	private static $file;
	
	//An array holding the types of log messages.
	static $logtype=array(
		'db'=>'DATABASE',
		'reg'=>'REGISTRY',
		'evt'=>'EVENTS',
		'int'=>'INTEGRITY'
	);
	
	//Performs a few basic housekeepings to initialize the logger.
	public static function init() {
		self::$file=file_exists('log.txt');
		if(!self::$file) self::$file=fopen('log.txt','w');
		else self::$file=fopen('log.txt','a+');
		$permitted=@chmod('log.txt',0777);
	}
	
	//Dumps a log message to a file.
	public static function dump($type,$message) {
		fwrite(self::$file,'['.time().']'.self::$logtype[$type].':'.$message.'\n');
	}
	
	//Closes the log file at shutdown.
	public static function shutdown() {
		fclose(self::$file);
	}
}

?>
