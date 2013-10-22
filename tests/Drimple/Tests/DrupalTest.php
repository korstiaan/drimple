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

use Drunit\TestCase;

use Drunit\Drunit;
class DrupalTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        Drunit::enableModule(__DIR__.'/../../../module', array('drimple'));
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
        Drunit::enableModule(__DIR__.'/../../drimple_test', array('drimple_test'));
        $drimple = drimple();

        $this->assertSame('bar',$drimple->get('foo'));
    }
}
