<?php

namespace Tests\Unit;


use App\Calculator;
use Tests\TestCase;

class CalculatorTest extends TestCase
{
    public function testPeek()
    {
        $calculator = new Calculator([1, 2]);

        $this->assertEquals(2, $calculator->peek());
    }

    public function testPeekReturnsNullWhenStackIsEmpty()
    {
        $calculator = new Calculator;

        $this->assertEquals(null, $calculator->peek());
    }

    public function testPush()
    {
        $calculator = new Calculator;

        $calculator->push(1);

        $this->assertEquals([1], $calculator->getStack());
    }

    public function testPushTwoNumbers()
    {
        $calculator = new Calculator;

        $calculator->push(1);
        $calculator->push(2.5);

        $this->assertEquals([1, 2.5], $calculator->getStack());
    }

    public function testPop()
    {
        $calculator = new Calculator([1]);

        $this->assertEquals(1, $calculator->pop());
        $this->assertEmpty($calculator->getStack());
    }

    public function testPopTwoNumbers()
    {
        $calculator = new Calculator([1, 2]);

        $this->assertEquals(2, $calculator->pop());
        $this->assertEquals([1], $calculator->getStack());
        $this->assertEquals(1, $calculator->pop());
        $this->assertEmpty($calculator->getStack());
    }

    public function testAdd()
    {
        $calculator = new Calculator([1, 2]);

        $calculator->add();

        $this->assertEquals([3], $calculator->getStack());
    }

    public function testAddTwoTimes()
    {
        $calculator = new Calculator([1, 2, 3]);

        $calculator->add(); // [1, 5]
        $calculator->add(); // [6]

        $this->assertEquals([6], $calculator->getStack());
    }

    public function testSubtract()
    {
        $calculator = new Calculator([1, 2]);

        $calculator->subtract();

        $this->assertEquals([-1], $calculator->getStack());
    }

    public function testSubtractTwoTimes()
    {
        $calculator = new Calculator([1, 2, 3]);

        $calculator->subtract(); // [1, -1]
        $calculator->subtract(); // [2]

        $this->assertEquals([2], $calculator->getStack());
    }
}