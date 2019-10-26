<?php

namespace Test\Sample;

use Pipeline\Bag\BagInterface;
use Pipeline\MiddlewareInterface;

/**
 * Class ThirdMiddleware
 *
 * @package Sample
 */
class ThirdMiddleware implements MiddlewareInterface
{
    /**
     * @var BagInterface
     */
    private $bag;

    /**
     * Doing dome stuff and returns result or null, if it is making some action and don't returns something;
     */
    public function handle()
    {
        return true;
    }

    /**
     * Used when we want to specify what middleware should be next. If it is not - throwing exception
     * Return null if this middleware not waiting for some other middleware on next step
     *
     * @return string|null
     */
    public function next(): ?string
    {
        return 'FifthMiddleware';
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