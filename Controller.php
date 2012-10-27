<?php
/**
 * This file contains the super-class for all controllers.
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
 * An instance of this class represents a generic controller super-class which any controller class may extend.
 * 
 * <code>
 * require_once('Controller.php');
 * 
 * class Sample extends Controller {
 *      function __construct() {
 *          $this->assoc['methodname']='ClassName';
 *          $this->loc['ClassName']='ClassFile.php';
 *      }
 * }
 * </code> 
 */
class Controller {
        /**
         * Contains the mappings of the method names to the respective class names
         * 
         * @var array 
         */
	protected $assoc=array();
        
        /**
         * Contains the mappings of the class names to the respective class files
         * 
         * @var array
         */
	protected $loc=array();
        
        /**
         * Loads a sub-module and returns an object of the sub-module class
         * 
         * @param string $method
         * @return null|object 
         */
	public function loadSubModule($method) {
		//Check whether method is registered with the controller.
		if(!array_key_exists($method,$this->assoc)) {
			ErrorHandler::fire('int','Method not registered with controller.');
			return null;
		}
		
		//Load the sub-module.
		require_once($this->loc[$this->assoc[$method]]);
		
		//Create an object of the sub-module.
		$submod=new $this->assoc[$method]($this);
		
		//If all executes successfully.
		return $submod;
	}
	
	/**
         * Invokes a method of the current module with the data supplied as an array or arguments
         * 
         * @param string $method
         * @param array $data
         * @return array 
         */
	function invoke($method,$data) {
		//Loads the sub-module if the method is registered with the controller.		
		$submod=$this->loadSubModule($method);	
		if($submod==null) return array(false,ErrorHandler::fetchTrace());
		
		//Invoke method of sub-module.
		$result=call_user_func_array(array($submod,$method),$data);
		return $result;
	}
}

?>
