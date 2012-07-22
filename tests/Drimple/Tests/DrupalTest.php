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

class DrupalTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        if (!defined('DRUPAL_ROOT')) {
            $this->markTestSkipped('Drupal needs to be bootstrapped for this test');
        }
        
        if (!function_exists('drimple')) {
            $this->markTestSkipped('Drupal needs to be bootstrapped and modules enabled');
        }
    }
    public function testSingleton()
    {
        $drimple1 = \Drimple\Drimple::getInstance();
        $drimple2 = drimple();

        $this->assertSame($drimple1, $drimple2);
    }

    public function testGetter()
    {
        $drimple1 = drimple();
        $drimple2 = drimple();

        $this->assertSame($drimple1, $drimple2);

        $this->assertInstanceOf('Drimple\Drimple', $drimple1);
    }

    public function testProvideHook()
    {
        $drimple = drimple();

        $this->assertSame('bar',$drimple->get('foo'));
    }
}
