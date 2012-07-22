<?php

/**
 * This file is part of Drimple
 *
 * (c) Korstiaan de Ridder <korstiaan@korstiaan.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use Drunit\Drunit;

require __DIR__ . '/../vendor/autoload.php';

Drunit::bootstrap();
Drunit::enableModule(__DIR__.'/../', array('drimple','drimple_test'));
