<?php

namespace Test;

use PHPUnit\Framework\TestCase;
use Pipeliner\Bag\RuntimeBag;
use Pipeliner\Exceptions\PipeException;
use Pipeliner\Middleware\ClosureMiddleware;
use Pipeliner\Middleware\MiddlewareInterface;
use Pipeliner\Pipeline;
use ReflectionException;
use Test\Sample\FirstMiddleware;
use Test\Sample\InvalidMiddleware;
use Test\Sample\SecondMiddleware;
use Test\Sample\ThirdMiddleware;

class PipelineTest extends TestCase
{
    /**
     * @var Pipeline
     */
    private $pipeline;

    /**
     * @throws ReflectionException
     */
    public function setUp(): void
    {
        $this->pipeline = new Pipeline(new RuntimeBag());

        $this->pipeline->pipe(new FirstMiddleware());
        $this->pipeline->pipe(new SecondMiddleware());
        $this->pipeline->pipe(new ClosureMiddleware('iAmClosureMiddleware', function(){
            return true;
        }));
    }

    /**
     * @throws PipeException
     * @throws ReflectionException
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
        $bag = new RuntimeBag();
        $bag->put('Test', 'data');

        $this->assertEquals('data', (new Pipeline($bag))->getPipelineBag()->getLast());
    }

    /**
     * @throws PipeException
     * @throws ReflectionException
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
     * @throws ReflectionException
     */
    public function testExecInvalidMiddleware()
    {
        $this->expectException(PipeException::class);

        $this->pipeline->setPipelineCollection([new InvalidMiddleware()]);
        $this->pipeline->exec();
    }
}
