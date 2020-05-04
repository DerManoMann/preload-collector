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

/**
 * Laravel service provider.
 */
class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $configPath = __DIR__ . '/preload-collector.php';
        $this->mergeConfigFrom($configPath, 'preload-collector');
    }

    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        $preloadPath = __DIR__ . '/preload.php';
        $this->publishes([$preloadPath => base_path('preload.php')], 'preload');

        $configPath = __DIR__ . '/preload-collector.php';
        $this->publishes([$configPath => config_path('preload-collector.php')], 'config');

        if ($this->app['config']->get('preload-collector.enabled')) {
            $kernel = $this->app[\Illuminate\Contracts\Http\Kernel::class];
            $kernel->pushMiddleware(MiddlewareCollector::class);
        }
    }
}
