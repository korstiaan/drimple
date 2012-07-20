<?php

/**
 * This file is part of Drimple
 *
 * (c) Korstiaan de Ridder <korstiaan@korstiaan.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use Drimple\Drimple;
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
	
	/**
	 * Singleton, for BC purposes 
	 *
	 * @return Drimple
	 */
	static public function getInstance() 
	{
		return drimple();
	}
}
