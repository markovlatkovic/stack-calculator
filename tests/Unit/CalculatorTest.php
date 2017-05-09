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
}