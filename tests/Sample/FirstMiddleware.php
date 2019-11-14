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
        for($i=0; $i < 100000; $i++) {
            $result = $i * 1.25;
        }
    }
}