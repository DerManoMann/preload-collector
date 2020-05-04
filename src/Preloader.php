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
 * The preloader used in the `preload` script.
 */
class Preloader
{
    protected StorageInterface $storage;
    protected array $namespaces = ['*'];
    protected array $ignores = [];
    protected bool $verbose;

    /**
     * Create a new instance with the given classes to preload.
     *
     * @param $storage the storage instance
     */
    public function __construct(StorageInterface $storage, bool $verbose = false)
    {
        $this->storage = $storage;
        $this->verbose = $verbose;
    }

    /**
     * Set an optional list of namespace filters.
     *
     * If set, only classes with their `FQCN` matching this list will be loaded.
     *
     * @param string ...$namespaces List of namespaces to preload.
     *
     * @return $this
     */
    public function namespaces(string ...$namespaces): Preloader
    {
        $this->namespaces = $namespaces;

        return $this;
    }

    /**
     * Set an optional list of string pattern to exclude from preloading.
     *
     * @param string ...$names List if names to exclude.
     *
     * @return $this
     */
    public function ignore(string ...$names): Preloader
    {
        $this->ignores = array_merge(
            $this->ignores,
            $names
        );

        return $this;
    }

    /**
     * Load all configured classes.
     */
    public function load(): void
    {
        $requested = 0;
        $loaded = 0;
        foreach ($this->storage->loadClassList() as $class) {
            ++$requested;
            if ($this->accept($class) && !class_exists($class, false)) {
                ++$loaded;
                if ($this->verbose) {
                    echo "[Preloader] Loading {$class}" . PHP_EOL;
                }
                class_exists($class, true);
            }
        }

        if ($this->verbose) {
            echo "[Preloader] Preloaded {$loaded}/{$requested} classes" . PHP_EOL;
        }
    }

    /**
     * Return `true` if the given class name should be preloaded.
     *
     * @param string|null $name the class name
     *
     * @return bool `true` to preload; `false` otherwise
     */
    private function accept(?string $name): bool
    {
        if (null === $name || empty($name)) {
            return false;
        }

        foreach ($this->ignores as $ignore) {
            if (0 === strpos($name, $ignore)) {
                return false;
            }
        }

        foreach ($this->namespaces as $namespace) {
            if (0 === strpos($name, $namespace) || '*' === $namespace) {
                return true;
            }
        }

        return false;
    }
}
