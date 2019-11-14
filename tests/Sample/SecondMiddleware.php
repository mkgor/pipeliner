<?php

namespace Test\Sample;

use Pipeliner\Middleware\AbstractMiddleware;

/**
 * Class SecondMiddleware
 *
 * @package Sample
 */
class SecondMiddleware extends AbstractMiddleware
{
    /**
     * Doing dome stuff and returns result or null, if it is making some action and don't returns something;
     */
    public function handle()
    {
        for($i=0; $i < 200000; $i++) {
            $result = $i * 2.25;
        }
        return true;
    }

    public function next(): ?string
    {
        return 'iAmClosureMiddleware';
    }
}