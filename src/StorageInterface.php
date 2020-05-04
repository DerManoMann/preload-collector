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
 * Simple storage layer.
 */
interface StorageInterface
{
    /**
     * Load previously stored class list.
     */
    public function loadClassList(): ?array;

    /**
     * Store new class list.
     */
    public function store(array $classList): void;
}
