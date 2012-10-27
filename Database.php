<?php
/**
 * This file contains the static Database class.
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
 * 
 * @category   PHP
 * @package    Frisby
 * @author     Rajdeep Das <das.rajdeep97@gmail.com>
 * @copyright  Copyright 2012 Rajdeep Das
 * @license    http://www.gnu.org/licenses/gpl.txt  The GNU General Public License
 * @version    GIT: v1.0
 * @link       https://github.com/dasrajdeep/frisby
 * @since      File available since Release 1.0
 */

/**
 * An instance of this class represents a Database helper to manage database operations.
 * 
 * <code>
 * require_once('Database.php');
 * 
 * $resultset=Database::get('table_name','columns','criterion');
 * </code>  
 */
class Database {
    /**
     * The database connection object
     * 
     * @var object 
     */
    private static $con = FALSE;
    
    /**
     * The prefix used for all tables in the database used by the engine
     * 
     * @var string 
     */
    private static $prefix = '';

    /**
     * Connects to the database server and the required database
     * 
     * @return boolean 
     */
    public static function connect() {
        require_once('config/database.inc');
        self::$con = @mysql_connect($database["host"], $database["username"], $database["password"]);
        if (!self::$con) {
            ErrorHandler::fire('db', 'Unable to connect to database. ' . mysql_error());
            return FALSE;
        }
        $selected = @mysql_select_db($database["name"], self::$con);
        if (!$selected) {
            ErrorHandler::fire('db', 'Unable to connect to database. ' . mysql_error());
            return FALSE;
        }
        self::$prefix = $database['prefix'];
        return TRUE;
    }
    
    /**
     * Disconnects from the database 
     */
    public static function disconnect() {
        @mysql_close(self::$con);
        if (mysql_errno())
            ErrorHandler::fire('db', 'MySQL<' . mysql_errno() . '>' . mysql_error());
    }

    /**
     * Fetches data from the database
     * 
     * @param string $table
     * @param string $values
     * @param array $criterion
     * @return null|array 
     */
    public static function get($table,$values,$criterion) {
        if(!self::$con) return NULL;
        $table=self::$prefix.$table;
        if($criterion!=FALSE) $criterion=" WHERE ".$criterion;
        else $criterion="";
        $query=sprintf("SELECT %s FROM %s%s",$values,$table,$criterion);
        $result=mysql_query($query,self::$con);
		if(mysql_errno()) ErrorHandler::fire('db','MySQL<'.mysql_errno().'>'.mysql_error().' `'.$query.'`');
        if(!$result) return NULL;
        $rows=array();
        while($row=mysql_fetch_assoc($result)) array_push($rows, $row); 
        return $rows;
    }
    
    /**
     * Inserts data into the database
     * 
     * @param string $table
     * @param array $fields
     * @param array $data
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
            ErrorHandler::fire('db', 'MySQL<' . mysql_errno() . '>' . mysql_error() . ' `' . $query . '`');
        return $result;
    }

    /**
     * Updates data in the database
     * 
     * @param string $table
     * @param array $fields
     * @param array $data
     * @param string $criterion
     * @return boolean 
     */
    public static function update($table, $fields, $data, $criterion) {
        if (!self::$con)
            return FALSE;
        $table = self::$prefix . $table;
        $assignments = array();
        for ($i = 0; $i < count($fields); $i++)
            array_push($assignments, sprintf("%s='%s'", $fields[$i], $data[$i]));
        $set = implode(",", $assignments);
        $query = sprintf("UPDATE %s SET %s WHERE %s", $table, $set, $criterion);
        $result = mysql_query($query, self::$con);
        if (mysql_errno())
            ErrorHandler::fire('db', 'MySQL<' . mysql_errno() . '>' . mysql_error() . ' `' . $query . '`');
        if (!$result)
            return FALSE;
        return true;
    }

    /**
     * Deletes data from the database
     * 
     * @param string $table
     * @param string $match
     * @return boolean 
     */
    public static function remove($table, $match) {
        if (!self::$con)
            return false;
        $table = self::$prefix . $table;
        $query = sprintf("DELETE FROM %s WHERE %s", $table, $match);
        $result = mysql_query($query, self::$con);
        if (mysql_errno())
            ErrorHandler::fire('db', 'MySQL<' . mysql_errno() . '>' . mysql_error() . ' `' . $query . '`');
        if (!$result)
            return FALSE;
        return true;
    }

    /**
     * Executes a user-specified query on the database
     * 
     * @param string $query
     * @return boolean|object 
     */
    public static function query($query) {
        if (!self::$con)
            return false;
        $result = mysql_query($query, self::$con);
        if (mysql_errno())
            ErrorHandler::fire('db', 'MySQL<' . mysql_errno() . '>' . mysql_error() . ' `' . $query . '`');
        if (!$result)
            return false;
        else
            return $result;
    }
	
    /**
     * Fetches the database prefix used
     * 
     * @return string 
     */
    public static function getPrefix() {
        return self::$prefix;
    }
}
?>
