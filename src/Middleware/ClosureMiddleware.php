<?php

namespace Pipeliner\Middleware;

use Closure;

/**
 * Class ClosureMiddleware
 *
 * @package Middleware
 */
class ClosureMiddleware extends AbstractMiddleware
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var null | string
     */
    private $next = null;

    /**
     * @var Closure
     */
    private $handler;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return string|null
     */
    public function next() :?string
    {
        return $this->next;
    }

    /**
     * @param null $next
     */
    public function setNext($next): void
    {
        $this->next = $next;
    }

    /**
     * @return Closure
     */
    public function getHandler(): Closure
    {
        return $this->handler;
    }

    /**
     * @param Closure $handler
     */
    public function setHandler(Closure $handler): void
    {
        $this->handler = $handler;
    }

    /**
     * ClosureMiddleware constructor.
     *
     * @param string      $name
     * @param Closure     $handler
     * @param string|null $next
     */
    public function __construct($name, Closure $handler, $next = null)
    {
        $this->setName($name);
        $this->setNext($next);
        $this->setHandler($handler);
    }

    /**
     * Doing dome stuff and returns result or null, if it is making some action and don't returns something;
     *
     * @return mixed
     */
    public function handle()
    {
        $handler = $this->getHandler();

        return $handler();
    }
}