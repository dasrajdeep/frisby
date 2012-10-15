<?php

class Database {
	//The database connection object.
    private static $con=FALSE;
    
	//The prefix of the database tables.
	private static $prefix='';
	
	//Connects to the database and executes queries.
    public static function connect() {
		require_once('config/database.inc');
        self::$con=mysql_connect($database["host"],$database["username"],$database["password"]);
        if(!self::$con) {
            ErrorHandler::fire('db','Unable to connect to database. '.mysql_error());
            return FALSE;
        }
        $selected=@mysql_select_db($database["name"],self::$con);
        if(!$selected) {
            ErrorHandler::fire('db','Unable to connect to database. '.mysql_error());
            return FALSE;
        }
		self::$prefix=$database['prefix'];
        return TRUE;
    }
    
    public static function disconnect() {
        @mysql_close(self::$con);
		if(mysql_errno()) ErrorHandler::fire('db','MySQL<'.mysql_errno().'>'.mysql_error());
    }
    
    //Fetch a set of data as a set of associative arrays.
    public static function get($table,$values,$criterion) {
        if(!self::$con) return NULL;
        $table=self::$prefix.$table;
        if($criterion!=FALSE) $criterion=" WHERE ".$criterion;
        else $criterion="";
        $query=sprintf("SELECT %s FROM %s%s",$values,$table,$criterion);
        $result=mysql_query($query,self::$con);
		if(mysql_errno()) ErrorHandler::fire('db','MySQL<'.mysql_errno().'>'.mysql_error());
        if(!$result) return NULL;
        $rows=array();
        while($row=mysql_fetch_assoc($result)) array_push($rows, $row); 
        return $rows;
    }
    
	//Add data to the database.
    public static function add($table,$fields,$data) {
        if(!self::$con) return FALSE;
        $table=self::$prefix.$table;
        $fields=implode(",", $fields);
        for($i=0;$i<count($data);$i++) $data[$i]=sprintf("'%s'",$data[$i]);
        $data=implode(",", $data);
        $query=sprintf("INSERT INTO %s (%s) VALUES (%s)",$table,$fields,$data);
        $result=mysql_query($query,self::$con);
		if(mysql_errno()) ErrorHandler::fire('db','MySQL<'.mysql_errno().'>'.mysql_error());
        return $result;
    }
    
	//Update data in the database.
    public static function update($table,$fields,$data,$criterion) {
        if(!self::$con) return FALSE;
        $table=self::$prefix.$table;
        $assignments=array();
        for($i=0;$i<count($fields);$i++) array_push($assignments, sprintf("%s='%s'",$fields[$i],$data[$i]));
        $set=implode(",", $assignments);
        $query=sprintf("UPDATE %s SET %s WHERE %s",$table,$set,$criterion);
        $result=mysql_query($query,self::$con);
		if(mysql_errno()) ErrorHandler::fire('db','MySQL<'.mysql_errno().'>'.mysql_error());
        if(!$result) return FALSE;
        return true;
    }
    
	//Delete data from the database.
    public static function remove($table,$match) {
        if(!self::$con) return false;
        $table=self::$prefix.$table;
        $query=sprintf("DELETE FROM %s WHERE %s",$table,$match);
        $result=mysql_query($query,self::$con);
		if(mysql_errno()) ErrorHandler::fire('db','MySQL<'.mysql_errno().'>'.mysql_error());
        if(!$result) return FALSE;
        return true;
    }
    
	//Execute an arbitrary query whose behaviour is not defined by the above functions.
    public static function query($query) {
        if(!self::$con) return false;
        $result=mysql_query($query,self::$con);
		if(mysql_errno()) ErrorHandler::fire('db','MySQL<'.mysql_errno().'>'.mysql_error());
        if(!$result) return false;
        else return $result;
    }
	
	//Gets the database table prefix.
	public static function getPrefix() {
		return self::$prefix;
	}
}
?>
