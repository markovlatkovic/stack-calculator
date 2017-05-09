<?php

namespace Tests\Unit;


use App\Calculator;
use Tests\TestCase;

class CalculatorTest extends TestCase
{
    public function testConstructorWithEmptyStack()
    {
        $calculator = new Calculator;

        $this->assertEquals([], $calculator->getStack());
    }

    public function testConstructorWithNonEmptyStack()
    {
        $calculator = new Calculator([1, 2, 3]);

        $this->assertEquals([1, 2, 3], $calculator->getStack());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testConstructorThrowsExceptionWithNonNumericArrayElements()
    {
        new Calculator(['']);
    }

    public function testPeek()
    {
        $calculator = new Calculator([1, 2]);

        $this->assertEquals(2, $calculator->peek());
    }

    /**
     * @expectedException \App\Exceptions\StackUnderflowException
     */
    public function testPeekThrowsExceptionWhenStackIsEmpty()
    {
        $calculator = new Calculator;
        $calculator->peek();
    }

    public function testPush()
    {
        $calculator = new Calculator;

        $calculator->push(1);

        $this->assertEquals([1], $calculator->getStack());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testPushThrowsErrorWhenArgumentIsNonNumeric()
    {
        $calculator = new Calculator;

        $calculator->push('');
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

    /**
     * @expectedException \App\Exceptions\StackUnderflowException
     */
    public function testPopThrowsExceptionWhenStackIsEmpty()
    {
        $calculator = new Calculator;
        $calculator->pop();
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

    /**
     * @expectedException \App\Exceptions\StackUnderflowException
     */
    public function testAddThrowsExceptionWhenStackIsEmpty()
    {
        $calculator = new Calculator;
        $calculator->add();
    }

    /**
     * @expectedException \App\Exceptions\StackUnderflowException
     */
    public function testAddThrowsExceptionWhenStackContainsOneElement()
    {
        $calculator = new Calculator([1]);
        $calculator->add();
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

    /**
     * @expectedException \App\Exceptions\StackUnderflowException
     */
    public function testSubtractThrowsExceptionWhenStackIsEmpty()
    {
        $calculator = new Calculator;
        $calculator->subtract();
    }

    /**
     * @expectedException \App\Exceptions\StackUnderflowException
     */
    public function testSubtractThrowsExceptionWhenStackContainsOneElement()
    {
        $calculator = new Calculator([1]);
        $calculator->subtract();
    }

    public function testMultiply()
    {
        $calculator = new Calculator([10, 2]);

        $calculator->multiply();

        $this->assertEquals([20], $calculator->getStack());
    }

    public function testMultiplyTwoTimes()
    {
        $calculator = new Calculator([10, 2, 3]);

        $calculator->multiply(); // [10, 6]
        $calculator->multiply(); // [60]

        $this->assertEquals([60], $calculator->getStack());
    }

    /**
     * @expectedException \App\Exceptions\StackUnderflowException
     */
    public function testMultiplyThrowsExceptionWhenStackIsEmpty()
    {
        $calculator = new Calculator;
        $calculator->multiply();
    }

    /**
     * @expectedException \App\Exceptions\StackUnderflowException
     */
    public function testMultiplyThrowsExceptionWhenStackContainsOneElement()
    {
        $calculator = new Calculator([1]);
        $calculator->multiply();
    }

    public function testDivide()
    {
        $calculator = new Calculator([10, 2]);

        $calculator->divide();

        $this->assertEquals([5], $calculator->getStack());
    }

    public function testDivideTwoTimes()
    {
        $calculator = new Calculator([10, 10, 2]);

        $calculator->divide(); // [10, 5]
        $calculator->divide(); // [2]

        $this->assertEquals([2], $calculator->getStack());
    }

    /**
     * @expectedException \App\Exceptions\StackUnderflowException
     */
    public function testDivideThrowsExceptionWhenStackIsEmpty()
    {
        $calculator = new Calculator;
        $calculator->divide();
    }

    /**
     * @expectedException \App\Exceptions\StackUnderflowException
     */
    public function testDivideThrowsExceptionWhenStackContainsOneElement()
    {
        $calculator = new Calculator([1]);
        $calculator->divide();
    }

    /**
     * @expectedException \App\Exceptions\DivisionByZeroException
     */
    public function testDivideThrowsExceptionWhenDivisorIsZero()
    {
        $calculator = new Calculator([1, 0]);
        $calculator->divide();
    }
}
