<?php

namespace Test\Sample;

use Pipeliner\Middleware\AbstractMiddleware;

/**
 * Class FirstMiddleware
 *
 * @package Sample
 */
class FirstMiddleware extends AbstractMiddleware
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
}