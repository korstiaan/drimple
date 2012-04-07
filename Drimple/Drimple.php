<?php
/**
 *  Drimple
 *  Copyright (C) 2012  Korstiaan de Ridder <korstiaan [at] korstiaan.com>
 *
 *	This file is part of Drimple
 *
 *  Drimple is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  Drimple is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with Drimple.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Drimple;

use Drimple\Provider\ServiceProviderInterface;

class Drimple extends \Pimple
{
	/**
	 * Registers a service provider
	 * 
	 * @param 	ServiceProviderInterface 	$provider
	 */
	public function register(ServiceProviderInterface $provider, array $values = array())
	{
	 	foreach ($values as $key => $value) {
			$this[$key] = $value;
		}
		
		$provider->register($this);
	}
	
	/**
	 * Convenience method for getting a service or parameter
	 * 
	 * @param 	string 						$s
	 * @throws 	\InvalidArgumentException	In case service / parameter isn't defined
	 * @return	mixed
	 */
	public function get($s) 
	{
		if (!isset($this[$s])) {
			throw new \InvalidArgumentException("Service / parameter '{$s}' isn't defined");
		}
		
		return $this[$s];
	}
	
	/**
	 * Checks if given service of parameter is defined
	 * 
	 * @param 	string 	$s
	 * @return	boolean
	 */
	public function has($s) 
	{
		return isset($this[$s]);
	}
	
	static protected $instances = array();
	
	/** 
	 * Returns the singleton instance of called class (oh my)
	 *  
	 * @return 	Drimple	
	 */
	static public function getInstance()
	{	
		$class = get_called_class();
		
		if (!isset(self::$instances[$class])) {
			self::$instances[$class] = new static;
		}
		
		return self::$instances[$class];
	}
}