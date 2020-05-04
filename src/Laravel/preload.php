<?php

use Radebatz\PreloadCollector\Preloader;
use Radebatz\PreloadCollector\Storage\FileStorage;

require __DIR__ . '/vendor/autoload.php';

(new Preloader(new FileStorage(__DIR__), false))
    ->ignore(
        Illuminate\Support\Carbon::class,
        '__',
        'DebugBar',
        'Barryvdh\Debugbar',
        'Whoops',
        'Tests',
        'PHPUnit'
    )
    ->load();
