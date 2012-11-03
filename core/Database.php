<?php
/**
 * This file contains the Database class.
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

/**
 * An instance of this class represents a Database helper to manage database operations.
 * 
 * <code>
 * require_once('Database.php');
 * 
 * Database::connect();
 * </code>  
 * 
 * @package    frisby\core
 * @category   PHP
 * @author     Rajdeep Das <das.rajdeep97@gmail.com>
 * @copyright  Copyright 2012 Rajdeep Das
 * @license    http://www.gnu.org/licenses/gpl.txt  The GNU General Public License
 * @version    GIT: v1.0
 * @link       https://github.com/dasrajdeep/frisby
 * @since      Class available since Release 1.0
 */
class Database {
    /**
     * The database connection object.
     * 
     * Contains the database handler returned by the mysql_connect() method.
     * 
     * @var object 
     */
    private static $con = FALSE;
    
    /**
     * The database prefix.
     * 
     * The prefix used for all tables in the database. 
     * This prefix is automatically prepended to the names of tables and views before querying on the database.
     * 
     * @var string 
     */
    private static $prefix = '';

    /**
     * Connects to the database.
     * 
     * Connects to the database server and selects the specified database.
     * The credentials used here i.e. hostname,username,password are read from the configuration file 'database.inc'.
     * This file needs to be configured before the software runs properly.
     * 
     * <code>
     * Database::connect();
     * </code>
     * 
     * @return boolean 
     */
    public static function connect() {
        require_once('../config/database.inc');
        self::$con = mysql_connect($database["host"], $database["username"], $database["password"]);
        if (!self::$con) {
            EventHandler::fireError('db', 'Unable to connect to database. ' . mysql_error());
            return FALSE;
        }
        $selected = mysql_select_db($database["name"], self::$con);
        if (!$selected) {
            EventHandler::fireError('db', 'Unable to connect to database. ' . mysql_error());
            return FALSE;
        }
        self::$prefix = $database['prefix'];
        return TRUE;
    }
    
    /**
     * Disconnects from the database.
     * 
     * Disconnects from the database server and releases the handler.
     * 
     * <code>
     * Database::disconnect();
     * </code> 
     */
    public static function disconnect() {
        mysql_close(self::$con);
        if (mysql_errno())
            EventHandler::fireError('db', 'MySQL<' . mysql_errno() . '>' . mysql_error());
    }
	
	/**
     * Fetches the structure of a relation.
     * 
     * @param string $table
     * @return mixed[] 
     */
	public static function fetchStructure($table) {
		$table=self::$prefix.$table;
		$ptr=mysql_query("desc ".$table);
		$struct=array();
		while($r=mysql_fetch_assoc($ptr)) array_push($struct,array($r['Field'],$r['Type']));
		return $struct;
	}
	
    /**
     * Fetches data from the database.
     * 
     * The method accepts a table name as the first argument followed by a string of 
     * comma separated column names and a criterion string to be supplied to the 'WHERE' clause of the SQL query.
     * Data is returned in the form of a linear array of associative arrays.
     * Each element of the linear array represents a row fetched by the query on the database.
     * Each associative array represents a set of values for a particular row.
     * The keys of these arrays are the field names and the values, their corresponding values.
     * 
     * <code>
     * $resultset=Database::get('table_name','column_names','criterion');
     * </code>
     * 
     * @param string $table
     * @param string $values
     * @param string $criterion
     * @return mixed[] 
     */
    public static function get($table,$values,$criterion=null) {
        if(!self::$con) return NULL;
        $table=self::$prefix.$table;
        if($criterion && $criterion!=='') $criterion=" WHERE ".$criterion;
        else $criterion="";
        $query=sprintf("SELECT %s FROM %s%s",$values,$table,$criterion);
        $result=mysql_query($query,self::$con);
		if(mysql_errno()) EventHandler::fireError('db','MySQL<'.mysql_errno().'>'.mysql_error().' `'.$query.'`');
        if(!$result) return NULL;
        $rows=array();
        while($row=mysql_fetch_assoc($result)) array_push($rows, $row); 
        return $rows;
    }
    
    /**
     * Inserts data into the database.
     * 
     * The method accepts a table name as the first argument.
     * The second argument should be a string array containing the field names.
     * The third argument should also be a string array containing the values of the fields.
     * Note that the indices of the fields in the first array and the their respective values in 
     * the second array should coincide.
     * The method returns the value returned by the mysql_query() function.
     * 
     * <code>
     * $cols=array('col_1','col_2');
     * $vals=array('val_1','val_2');
     * Database::add('table_name',$cols,$vals);
     * </code>
     * 
     * @param string $table
     * @param string[] $fields
     * @param string[] $data
     * @return boolean 
     */
    public static function add($table, $fields, $data) {
        if (!self::$con)
            return FALSE;
        $table = self::$prefix . $table;
        $fields = implode(",", $fields);
        for ($i = 0; $i < count($data); $i++)
            $data[$i] = sprintf("'%s'", $data[$i]);
        $data = implode(",", $data);
        $query = sprintf("INSERT INTO %s (%s) VALUES (%s)", $table, $fields, $data);
        $result = mysql_query($query, self::$con);
        if (mysql_errno())
            EventHandler::fireError('db', 'MySQL<' . mysql_errno() . '>' . mysql_error() . ' `' . $query . '`');
        return $result;
    }

    /**
     * Updates data in the database.
     * 
     * The method accepts a table name followed by two string arrays containing
     * the field names and their corresponding values, and a criterion string.
     * The criterion string is directly used in the 'WHERE' clause of the query.
     * The method returns the value returned by the mysql_query() method.
     * 
     * <code>
     * $cols=array('col_1','col_2');
     * $vals=array('val_1','val_2');
     * Database::update('table_name',$cols,$vals,'criterion');
     * </code>
     * 
     * @param string $table
     * @param string[] $fields
     * @param string[] $data
     * @param string $criterion
     * @return boolean 
     */
    public static function update($table, $fields, $data, $criterion=null) {
        if (!self::$con)
            return FALSE;
        $table = self::$prefix . $table;
        $assignments = array();
        for ($i = 0; $i < count($fields); $i++)
            array_push($assignments, sprintf("%s='%s'", $fields[$i], $data[$i]));
        $set = implode(",", $assignments);
		if($criterion && $criterion!=='') $criterion=' WHERE '.$criterion;
		else $criterion='';
        $query = sprintf("UPDATE %s SET %s%s", $table, $set, $criterion);
        $result = mysql_query($query, self::$con);
        if (mysql_errno())
            EventHandler::fireError('db', 'MySQL<' . mysql_errno() . '>' . mysql_error() . ' `' . $query . '`');
        return $result;
    }

    /**
     * Deletes data from the database.
     * 
     * The method accepts a table name and a criterion string based on which it will perform deletions.
     * The return value is that returned by the mysql_query() method.
     * 
     * <code>
     * Database::remove('table_name','criterion');
     * </code>
     * 
     * @param string $table
     * @param string $match
     * @return boolean 
     */
    public static function remove($table, $match=null) {
        if (!self::$con)
            return false;
        $table = self::$prefix . $table;
		if($match && $match!=='') $match=' WHERE '.$match;
		else $match='';
        $query = sprintf("DELETE FROM %s%s", $table, $match);
        $result = mysql_query($query, self::$con);
        if (mysql_errno())
            EventHandler::fireError('db', 'MySQL<' . mysql_errno() . '>' . mysql_error() . ' `' . $query . '`');
        return $result;
    }

    /**
     * Executes a user-specified query on the database.
     * 
     * This method accepts a raw query and executes it on the database. 
     * However since the method is unaware of the type of data returned by the database server,
     * it returns a handler for the processed query. The handler can be used to fetch rows from the
     * database using the mysql_fetch_array() or mysql_fetch_assoc() methods.
     * 
     * <code>
     * $link=Database::query();
     * $rows=array();
     * while($row=mysql_fetch_assoc($link)) array_push($rows,$row);
     * </code>
     * 
     * @param string $query
     * @return object 
     */
    public static function query($query) {
        if (!self::$con)
            return false;
        $result = mysql_query($query, self::$con);
		if(preg_match('/^(select|SELECT)[ ]/',$query)===1) {
			$tmp=array();
			while($r=mysql_fetch_assoc($result)) array_push($tmp,$r);
			$result=$tmp;
		}
        if (mysql_errno())
            EventHandler::fireError('db', 'MySQL<' . mysql_errno() . '>' . mysql_error() . ' `' . $query . '`');
        return $result;
    }
	
    /**
     * Fetches the database prefix.
     * 
     * Fetches the prefix defined in the configuration file for the database schema.
     * 
     * <code>
     * $pre=Database::getPrefix();
     * </code>
     * 
     * @return string 
     */
    public static function getPrefix() {
        return self::$prefix;
    }
}
?>
