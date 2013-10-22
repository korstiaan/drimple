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

if (!class_exists('Drunit\\Drunit')) {
    throw new \RuntimeException('Drunit not found, make sure you have installed all dependencies (--dev)');
}
