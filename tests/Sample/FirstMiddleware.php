<?php

namespace Test\Sample;

use Pipeline\Bag\BagInterface;
use Pipeline\MiddlewareInterface;

/**
 * Class FirstMiddleware
 *
 * @package Sample
 */
class FirstMiddleware implements MiddlewareInterface
{
    private $bag;

    /**
     * Doing dome stuff and returns result or null, if it is making some action and don't returns something;
     */
    public function handle()
    {
        echo 'First middleware has done some stuff';
    }

    /**
     * Used when we want to specify what middleware should be next. If it is not - throwing exception
     *
     * @return string|null
     */
    public function next(): ?string
    {
        return 'SecondMiddleware';
    }

    /**
     * Injecting bag into middleware so it can use results from previous middlewares
     *
     * @param BagInterface $bag
     */
    public function setBag(BagInterface $bag)
    {
        $this->bag = $bag;
    }
}