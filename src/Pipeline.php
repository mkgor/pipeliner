<?php

namespace Pipeliner;

use Closure;
use Pipeliner\Bag\BagInterface;
use Pipeliner\Exceptions\PipeException;
use Pipeliner\Middleware\MiddlewareInterface;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;

/**
 * Class Pipeline
 *
 * @package Pipeline
 */
class Pipeline
{
    use BenchmarkTrait;

    /**
     * @var MiddlewareInterface[]
     */
    private $pipelineCollection = [];

    /**
     * @var BagInterface
     */
    private $pipelineBag;

    /**
     * @return BagInterface
     * @codeCoverageIgnore
     */
    public function getPipelineBag()
    {
        return $this->pipelineBag;
    }

    /**
     * @param BagInterface $pipelineBag
     *
     * @codeCoverageIgnore
     */
    public function setPipelineBag(BagInterface $pipelineBag)
    {
        $this->pipelineBag = $pipelineBag;
    }

    /**
     * Pipeline constructor.
     *
     * @param BagInterface $bag
     */
    public function __construct(BagInterface $bag)
    {
        $this->pipelineBag = $bag;
    }

    /**
     * @return MiddlewareInterface[]
     * @codeCoverageIgnore
     */
    public function getPipelineCollection()
    {
        return $this->pipelineCollection;
    }

    /**
     * Sets the pipeline
     *
     * @param MiddlewareInterface[] $pipelineCollection
     *
     * @codeCoverageIgnore
     */
    public function setPipelineCollection($pipelineCollection)
    {
        $this->pipelineCollection = $pipelineCollection;
    }

    /**
     * Adds new middleware into the pipeline.
     *
     * @param MiddlewareInterface $middleware
     *
     * @return Pipeline
     */
    public function pipe(MiddlewareInterface $middleware)
    {
        $this->pipelineCollection[] = $middleware;

        return $this;
    }

    /**
     * By calling this method, you are starting going through whole collection and calling each element of collection
     * in chain.
     *
     * Make sure that every item of collection is implementing MiddlewareInterface.
     *
     * Results from all middlewares will be contained in $pipelineBag array and will be passed to every middleware
     * in chain in its constructor.
     *
     * @param MiddlewareInterface[]|null $collection
     *
     * @return BagInterface
     *
     * @throws PipeException
     * @throws ReflectionException
     */
    public function exec(array $collection = null)
    {
        /** We can pass some array of middlewares and overwrite current pipeline if we needs */

        if ($collection == null) {
            $collection = $this->pipelineCollection;
        }

        $benchmarkArray = [];
        $awaitingFor = null;

        foreach ($collection as $i => $middlewareInstance) {
            $middlewareShortName = method_exists($middlewareInstance, 'getName') ? $middlewareInstance->getName() : (new ReflectionClass($middlewareInstance))->getShortName();

            if ($awaitingFor != null && $middlewareShortName != $awaitingFor) {
                throw new PipeException('Waiting for ' . $awaitingFor . ' in ' . $i . ' step of pipeline, got ' . $middlewareShortName);
            }

            if (!($middlewareInstance instanceof MiddlewareInterface)) {
                throw new PipeException($i . ' element of middlewares collection is not implements MiddlewareInterface');
            }

            $middlewareInstance->setBag($this->pipelineBag);

            $this->start();
            $this->pipelineBag->put($middlewareShortName, $middlewareInstance->handle());

            $benchmarkArray[$middlewareShortName] = $this->finish();
            $awaitingFor = $middlewareInstance->next();
        }

        $this->generateReport($benchmarkArray);

        return $this->getPipelineBag();
    }
}