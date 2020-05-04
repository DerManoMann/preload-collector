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

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Radebatz\PreloadCollector\Storage\FileStorage;

/**
 * PSR-15 middleware collector.
 */
class Psr15MiddlewareCollector implements MiddlewareInterface
{
    /**
     * Get the storage.
     */
    protected function getStorage(): StorageInterface
    {
        return new FileStorage();
    }

    /**
     * {@inheritdoc}
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $response = $handler->handle($request);

        (new Recorder($this->getStorage()))->record();

        return $response;
    }
}
