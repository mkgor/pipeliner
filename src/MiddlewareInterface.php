<?php

namespace Pipeline;

use Pipeline\Bag\BagInterface;

/**
 * Interface MiddlewareInterface
 *
 * @package Pipeline
 */
interface MiddlewareInterface
{
    /**
     * Injecting bag into middleware so it can use results from previous middlewares
     *
     * @param BagInterface $bag
     */
    public function setBag(BagInterface $bag);

    /**
     * Doing dome stuff and returns result or null, if it is making some action and don't returns something;
     *
     * @return mixed
     */
    public function handle();

    /**
     * Used when we want to specify what middleware should be next. If it is not - throwing exception
     *
     * @return string|null
     */
    public function next() : ?string;
}