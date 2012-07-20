<?php

/**
 * This file is part of Drimple
 *
 * (c) Korstiaan de Ridder <korstiaan@korstiaan.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Drimple\Tests;

class DrimpleTest extends \PHPUnit_Framework_TestCase
{
	public function testHas()
	{
		$drimple = new \Drimple\Drimple();
		
		$drimple['val'] 	= 'test';
		
		$drimple['service'] = function () {
            return new Service();
        };
        
        $this->assertTrue($drimple->has('val'));
        $this->assertTrue($drimple->has('service'));
        $this->assertFalse($drimple->has('no_service'));
	}
	
	public function testGet()
	{
		$drimple = new \Drimple\Drimple();
		
		$drimple['val'] 	= 'test';
		
		$drimple['service'] = function () {
            return new Service();
        };
        
        $this->assertInstanceOf('Drimple\Tests\Service', $drimple->get('service'));
        $this->assertSame('test',$drimple->get('val'));
	}
	
	/**
     * @expectedException InvalidArgumentException
     */
	public function testGetException()
	{
		$drimple = new \Drimple\Drimple();
		$drimple->get('foo');	
	}
	
	public function testProvider()
	{
		$drimple = new \Drimple\Drimple();
		$drimple->register(new Provider, array(
			'foo' => 'bar',			
		));
        $this->assertSame('bar',$drimple->get('foo'));
        $this->assertSame('bar2',$drimple->get('foo2'));
	}
}

class Service
{
}

class Provider implements \Drimple\Provider\ServiceProviderInterface
{
	public function register(\Drimple\Drimple $container)
	{
		$container['foo2'] = 'bar2';
	}
}