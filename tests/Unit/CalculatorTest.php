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
}