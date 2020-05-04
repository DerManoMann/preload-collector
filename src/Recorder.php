<?php declare(strict_types=1);

/*
* This file is part of the preload collector library.
*
* (c) Martin Rademacher <mano@radebatz.net>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Radebatz\PreloadCollector;

/**
 * The class list recorder.
 */
class Recorder
{
    protected $storage;

    /*
     * Create new instance with the given storage implementation.
     *
     * @param $storage The storage instance.
     */
    public function __construct(StorageInterface $storage)
    {
        $this->storage = $storage;
    }

    public function record(): void
    {
        $classList = array_merge(
            get_declared_classes(),
            get_declared_interfaces(),
            get_declared_traits()
        );

        if ($previousClassList = $this->storage->loadClassList()) {
            $classList = array_merge($classList, $previousClassList);
        }

        sort($classList);
        $classList = array_values(array_unique($classList));

        $this->storage->store($classList);
    }
}
