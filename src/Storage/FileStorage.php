<?php declare(strict_types=1);

/*
* This file is part of the preload collector library.
*
* (c) Martin Rademacher <mano@radebatz.net>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Radebatz\PreloadCollector\Storage;

use Composer\Autoload\ClassLoader;
use Radebatz\PreloadCollector\StorageInterface;

/**
 * File based storage.
 */
class FileStorage implements StorageInterface
{
    const PRELOAD_CLASSES_FILENAME = 'preload.json';

    protected $file;

    public function __construct(string $dirname = null, string $filename = self::PRELOAD_CLASSES_FILENAME)
    {
        $dirname = $dirname ?: static::getBaseDir();
        $this->file = sprintf('%s/%s', $dirname, $filename);
    }

    /**
     * {@inheritdoc}
     */
    public function loadClassList(): ?array
    {
        return file_exists($this->file) ? json_decode(file_get_contents($this->file)) : null;
    }

    /**
     * {@inheritdoc}
     */
    public function store(array $classList): void
    {
        file_put_contents($this->file, json_encode($classList));
    }

    public static function getBaseDir()
    {
        $rc = new \ReflectionClass(ClassLoader::class);

        return dirname($rc->getFileName(), 3);
    }
}
