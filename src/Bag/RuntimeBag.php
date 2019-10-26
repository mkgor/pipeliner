<?php

namespace Pipeliner\Bag;

/**
 * Class RuntimeBag
 *
 * @package Bag
 */
class RuntimeBag implements BagInterface
{
    /**
     * @var array
     */
    private $collection;

    /**
     * Writes the data which it gets from middleware.
     *
     * @param string $name
     * @param $data
     */
    public function put(string $name, $data)
    {
        $this->collection[$name] = $data;
    }

    /**
     * Getting the result from specified middleware
     *
     * @param $name
     *
     * @return mixed
     */
    public function getByName($name)
    {
        return $this->collection[$name];
    }

    /**
     * Getting data from last middleware
     *
     * @return mixed
     */
    public function getLast()
    {
        return end($this->collection);
    }

    /**
     * Getting all data from bag
     *
     * @return mixed
     */
    public function getAll()
    {
        return $this->collection;
    }
}