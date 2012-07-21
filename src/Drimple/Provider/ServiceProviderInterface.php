<?php

/**
 * This file is part of Drimple
 *
 * (c) Korstiaan de Ridder <korstiaan@korstiaan.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Drimple\Provider;

use Drimple\Drimple;

interface ServiceProviderInterface
{
    public function register(Drimple $container);
}
