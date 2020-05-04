<?php declare(strict_types=1);

/*
* This file is part of the preload collector library.
*
* (c) Martin Rademacher <mano@radebatz.net>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Radebatz\PreloadCollector\Laravel;

use Radebatz\PreloadCollector\Recorder;
use Radebatz\PreloadCollector\Storage\FileStorage;

/**
 * Laravel middleware collector.
 *
 * Will store the collected classes in the project root file `preload.json`.
 */
class MiddlewareCollector
{
    public function handle($request, \Closure $next)
    {
        return $next($request);
    }

    public function terminate($request, $response)
    {
        (new Recorder(new FileStorage(base_path())))
            ->record();
    }
}
