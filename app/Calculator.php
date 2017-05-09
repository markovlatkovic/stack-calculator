<?php

namespace App;


use App\Exceptions\DivisionByZeroException;
use App\Exceptions\StackUnderflowException;
use Illuminate\Support\Collection;
use App\Exceptions\InvalidArgumentException;

class Calculator
{
    /**
     * @var Collection the stack, wrapped in a collection object
     */
    private $stack;

    /**
     * Constructs a stack calculator.
     *
     * @param array $stack initial stack, must be an array of numbers
     * @throws InvalidArgumentException when array contains non-numeric elements
     */
    public function __construct(array $stack = [])
    {
        $this->stack = (new Collection($stack))->map(function ($item) {
            // only allow numeric elements
            if (! is_numeric($item)) {
                throw new InvalidArgumentException;
            }

            // cast values to floats
            return (float)$item;
        });
    }

    /**
     * Returns the top of the stack
     *
     * @return int stack[top]
     * @throws StackUnderflowException when the stack is empty
     */
    public function peek()
    {
        if ($this->stack->isEmpty()) {
            throw new StackUnderflowException;
        }

        return $this->stack->last();
    }

    /**
     * Pushes a number onto the stack
     *
     * @param float $number the number to push onto the stack
     * @throws InvalidArgumentException when the $number is non-numeric
     */
    public function push($number)
    {
        if (! is_numeric($number)) {
            throw new InvalidArgumentException;
        }

        // cast value to float
        $this->stack->push((float)$number);
    }

    /**
     * Returns the top from the stack and removes it
     *
     * @return float top of the stack that is removed
     * @throws StackUnderflowException when the stack is empty
     */
    public function pop()
    {
        if ($this->stack->isEmpty()) {
            throw new StackUnderflowException;
        }

        return $this->stack->pop();
    }

    /**
     * Removes the top and top-1 from the stack and replaces it with stack[top-1]+stack[top]
     *
     * @throws StackUnderflowException when the stack has less than two elements
     */
    public function add()
    {
        if ($this->stack->count() < 2) {
            throw new StackUnderflowException;
        }

        // [..., a, b]
        $b = $this->pop();
        $a = $this->pop();

        $this->push($a + $b);
        // [..., a + b]
    }

    /**
     * Removes the top and top-1 from the stack and replaces it with stack[top-1]-stack[top]
     *
     * @throws StackUnderflowException when the stack has less than two elements
     */
    public function subtract()
    {
        if ($this->stack->count() < 2) {
            throw new StackUnderflowException;
        }

        // [..., a, b]
        $b = $this->pop();
        $a = $this->pop();

        $this->push($a - $b);
        // [..., a - b]
    }

    /**
     * Removes the top and top-1 from the stack and replaces it with stack[top-1]*stack[top]
     *
     * @throws StackUnderflowException when the stack has less than two elements
     */
    public function multiply()
    {
        if ($this->stack->count() < 2) {
            throw new StackUnderflowException;
        }

        // [..., a, b]
        $b = $this->pop();
        $a = $this->pop();

        $this->push($a * $b);
        // [..., a * b]
    }

    /**
     * Removes the top and top-1 from the stack and replaces it with stack[top-1]/stack[top]
     *
     * @throws StackUnderflowException when the stack has less than two elements
     * @throws DivisionByZeroException when the stack[top] is zero
     */
    public function divide()
    {
        if ($this->stack->count() < 2) {
            throw new StackUnderflowException;
        }

        if ($this->peek() == 0) {
            throw new DivisionByZeroException;
        }

        // [..., a, b]
        $b = $this->pop();
        $a = $this->pop();

        $this->push($a / $b);
        // [..., a / b]
    }

    /**
     * Returns the current stack
     *
     * @return array the current stack
     */
    public function getStack()
    {
        return $this->stack->all();
    }
}
