<?php

namespace Pipeliner\Exceptions;

use Exception;

/**
 * Class PipeException
 *
 * @package Exceptions
 * @codeCoverageIgnore
 */
class PipeException extends Exception
{
    /**
     * PipeException constructor.
     *
     * @param string $message
     * @codeCoverageIgnore
     */
    public function __construct($message = "")
    {
        parent::__construct($message, 500, null);
    }
}