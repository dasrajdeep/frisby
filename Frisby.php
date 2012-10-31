<?php
/**
 * This file contains the bootstrap class for the engine.
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
 * An instance of this class represents a controller for the engine.
 * 
 * <code>
 * require_once('Frisby.php');
 * 
 * $frisby=new Frisby();
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
class Frisby {	
	
	/**
	* Contains a flag indicating boot errors.
	*
	* @var boolean
	*/
	private $bootError=false;
	
	/**
         * Boots up the engine and transfers control to the core. 
         */
	function __construct() {
		chdir('core');
		require_once('Bootstrap.php');
		if(ErrorHandler::hasErrors()) $this->bootError=true;
		chdir('..');
	}
	 /**
          * The master method to make a Frisby API or Admin function call.
          * 
          * The method requires a method name registered with the engine. 
          * The arguments for the method should be provided in the subsequent parameters.
          * The method can be an API method or an Administrative method.
          * All administrative methods must start with a prefix 'admin_' prior to the method name.
          * A list of administrative methods can be obtained by using the function 'getAdminMethods'.
          * A list of API methods can be obtained by using the function 'getAPIMethods'
          * 
          * @see Admin::getAdminMethods
          * @see Admin::getAPIMethods
          * 
          * <code>
          * $frisby->call('getAPIMethods');
          * $frisby->call('fetchEventNames','Profile');
          * </code>
          * 
          * @param string $method
          * @return mixed[] 
          */
	function call($method) {
		
		//Check for boot errors.
		if($this->bootError) return array(false,ErrorHandler::fetchTrace());
		
		chdir('core');
		
		$data=func_get_args();
		$data=array_slice($data,1);
		
		ErrorHandler::reset();
		
		if(preg_match('/^(admin_)(.)+/',$method)==1) {
			$method=substr($method,6);
			require_once('Admin.php');
			$admin=new Admin();
                        try {
                            $result=$admin->invoke($method,$data);
                        } catch(Exception $e) {}
		}
		else {
			require_once('Dispatcher.php');
			require_once('EventHandler.php');
			$api=new Dispatcher();
                        try {
                            $result=$api->dispatch($method,$data);
                        } catch(Exception $e) {}
		}
		
		chdir('..');
		
		if(ErrorHandler::hasErrors()) return array(false,ErrorHandler::fetchTrace());
		else return array(true,$result);
	}
}

?>
