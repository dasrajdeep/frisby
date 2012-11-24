<?php
/**
 * This file contains the API dispatcher for the engine.
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
 
/**
 * An instance of this class represents a dispatcher for the API methods registered in the engine.
 * 
 * <code>
 * require_once('Dispatcher.php');
 * 
 * $dispatcher=new Dispatcher();
 * $data=array(var1,...);
 * $resultset=$dispatcher->dispatch('method_name',$data);
 * </code> 
 * 
 * @package frisby\core
 * @category   PHP
 * @author     Rajdeep Das <das.rajdeep97@gmail.com>
 * @copyright  Copyright 2012 Rajdeep Das
 * @license    http://www.gnu.org/licenses/gpl.txt  The GNU General Public License
 * @version    GIT: v1.0
 * @link       https://github.com/dasrajdeep/frisby
 * @since      Class available since Release 1.0
 */
class Dispatcher {
	
	/**
         * Invokes a method supplied as argument and returns the data returned by the invoked method
         * 
         * @param string $method
         * @param mixed[] $data
         * @return mixed 
         */
	function dispatch($method,$data) {
		
		$route=Registry::read($method);
		
		$module=$route['module'];
		
		$loc=Registry::location($module);
		chdir('../modules/'.$loc);
		
		require_once($route['classname'].'.php');
		$class='frisby\\'.$route['classname'];
		$obj=new $class();
		$obj->setModuleName($module);
		$result=call_user_func_array(array($obj,$method),$data);
		
		chdir('../../core');
		
		return $result;
	}
	
}
?>
