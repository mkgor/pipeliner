<?php

namespace Test\Sample;

use Pipeliner\Middleware\AbstractMiddleware;

/**
 * Class ThirdMiddleware
 *
 * @package Sample
 */
class ThirdMiddleware extends AbstractMiddleware
{

    /**
     * Doing dome stuff and returns result or null, if it is making some action and don't returns something;
     */
    public function handle()
    {
        for($i=0; $i < 10000; $i++) {
            $result = $i * 1.852;
        }
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
}