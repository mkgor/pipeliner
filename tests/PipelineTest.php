<?php

namespace Test;

use Pipeline\Bag\RuntimeBag;
use Pipeline\Exceptions\PipeException;
use Pipeline\MiddlewareInterface;
use Pipeline\Pipeline;
use Test\Sample\FirstMiddleware;
use Test\Sample\InvalidMiddleware;
use Test\Sample\SecondMiddleware;
use Test\Sample\ThirdMiddleware;

class PipelineTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var Pipeline
     */
    private $pipeline;

    public function setUp(): void
    {
        $this->pipeline = new Pipeline(new RuntimeBag());

        $this->pipeline->pipe(new FirstMiddleware());
        $this->pipeline->pipe(new SecondMiddleware());
    }

    /**
     * @throws \Pipeline\Exceptions\PipeException
     * @throws \ReflectionException
     */
    public function testExec()
    {
        $this->assertEquals(true, $this->pipeline->exec()->getLast());
    }

    public function testPipe()
    {
        $this->assertContainsOnlyInstancesOf(MiddlewareInterface::class, $this->pipeline->getPipelineCollection());
    }

    public function test__construct()
    {
        $bag = new \Pipeline\Bag\RuntimeBag();
        $bag->put('Test', 'data');

        $this->assertEquals('data', (new Pipeline($bag))->getPipelineBag()->getLast());
    }

    /**
     * @throws PipeException
     * @throws \ReflectionException
     */
    public function testExecWaitingForMiddleware()
    {
        $this->expectException(PipeException::class);

        $this->pipeline->pipe(new ThirdMiddleware());
        $this->pipeline->pipe(new FirstMiddleware());
        $this->pipeline->exec();
    }

    /**
     * @throws PipeException
     * @throws \ReflectionException
     */
    public function testExecInvalidMiddleware()
    {
        $this->expectException(PipeException::class);

        $this->pipeline->setPipelineCollection([new InvalidMiddleware()]);
        $this->pipeline->exec();
    }
}
