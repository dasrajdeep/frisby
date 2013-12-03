<?php
/**
 * This file contains the support class for the module classes.
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
 * An instance of this class represents an invoker for module classes.
 * 
 * <code>
 * require_once('ModuleSupport.php');
 * 
 * $ms=new ModuleSupport();
 * </code> 
 * 
 * @package frisby\core
 * @category   PHP
 * @author     Rajdeep Das <das.rajdeep97@gmail.com>
 * @copyright  Copyright 2012 Rajdeep Das
 * @license    http://www.gnu.org/licenses/gpl.txt  The GNU General Public License
 * @version    GIT: v2.0
 * @link       https://github.com/dasrajdeep/frisby
 * @since      Class available since Release 2.0
 */
class ModuleSupport {
	/**
         * Contains the name of the current module.
         * 
         * @var string 
         */
	protected $modulename='';
        
        /**
         * Loads a module class and returns an object of the class.
         * 
         * @param string $method
         * @return null|object 
         */
	public function loadModuleClass($method) {
		$classname=Database::get('registry','classname',sprintf("method='%s' and module='%s'",$method,$this->modulename));
		if(count($classname)===0) {
			EventHandler::fireError('int','Module contains no such method.');
			return null;
		}
		$classname=$classname[0]['classname'];
		require_once($classname.'.php');
		$obj=new $classname();
		return $obj;
	}
	
		/**
         * Sets the module name for this object.
         * 
         * @param string $module
         */
	public function setModuleName($module) {
		$this->modulename=$module;
	}
	
        /**
         * Fetches the name of the current module.
         * 
         * @return string 
         */
	protected function getModuleName() {
		return $this->modulename;
	}
}

?>
