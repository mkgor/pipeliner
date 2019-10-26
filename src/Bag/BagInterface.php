<?php


namespace Pipeline\Bag;

/**
 * Interface BagInterface
 *
 * @package Bag
 */
interface BagInterface
{
    /**
     * Writes the data which it gets from middleware.
     *
     * @param $name
     * @param $data
     *
     * @return mixed
     */
    public function put(string $name, $data);

    /**
     * Getting the result from specified middleware
     *
     * @param $name
     *
     * @return mixed
     */
    public function getByName(string $name);

    /**
     * Getting data from last middleware
     *
     * @return mixed
     */
    public function getLast();

    /**
     * Getting all data from bag
     *
     * @return mixed
     */
    public function getAll();
}