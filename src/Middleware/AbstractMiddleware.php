<?php

namespace Pipeliner\Middleware;

use Pipeliner\Bag\BagInterface;

/**
 * Class AbstractMiddleware
 *
 * @package Middleware
 */
abstract class AbstractMiddleware implements MiddlewareInterface
{
    /**
     * @var BagInterface
     */
    private $bag;

    /**
     * Injecting bag into middleware so it can use results from previous middlewares
     *
     * @param BagInterface $bag
     */
    public function setBag(BagInterface $bag) {
        $this->bag = $bag;
    }

    /**
     * Used when we want to specify what middleware should be next. If it is not - throwing exception
     *
     * @return string|null
     */
    public function next() : ?string {
        return null;
    }
}