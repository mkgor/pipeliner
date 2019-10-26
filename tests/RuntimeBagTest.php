<?php

namespace Test;

use Pipeliner\Bag\RuntimeBag;

/**
 * Class RuntimeBagTest
 */
class RuntimeBagTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var RuntimeBag
     */
    private $bag;

    public function setUp(): void
    {
        $this->bag = new RuntimeBag();

        $this->bag->put('Test', ['date' => 'test']);
        $this->bag->put('Test_2', ['date' => 'test2']);
    }

    public function testGetByName()
    {
        $data = $this->bag->getByName('Test');

        $this->assertEquals(['date' => 'test'], $data);
    }

    public function testGetLast()
    {
        $this->assertEquals(['date' => 'test2'], $this->bag->getLast());
    }

    public function testGetAll()
    {
        $this->assertEquals([
            'Test' => ['date' => 'test'],
            'Test_2' => ['date' => 'test2']
        ], $this->bag->getAll());
    }
}
