<?php

namespace App;


use App\Exceptions\EmptyStackException;
use Illuminate\Support\Collection;

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
     */
    public function __construct(array $stack = [])
    {
        $this->stack = new Collection($stack);
    }

    /**
     * Returns the top of the stack
     *
     * @return int stack[top]
     * @throws EmptyStackException when the stack is empty
     */
    public function peek()
    {
        if ($this->stack->isEmpty()) {
            throw new EmptyStackException;
        }

        return $this->stack->last();
    }

    /**
     * Pushes a number onto the stack
     *
     * @param float $number the number to push onto the stack
     */
    public function push(float $number)
    {
        $this->stack->push($number);
    }

    /**
     * Returns the top from the stack and removes it
     *
     * @return float top of the stack that is removed
     */
    public function pop()
    {
        if ($this->stack->isEmpty()) {
            throw new EmptyStackException;
        }

        return $this->stack->pop();
    }

    /**
     * Removes the top and top-1 from the stack and replaces it with stack[top-1]+stack[top]
     */
    public function add()
    {
        if ($this->stack->count() < 2) {
            throw new EmptyStackException;
        }

        // [..., a, b]
        $b = $this->pop();
        $a = $this->pop();

        $this->push($a + $b);
        // [..., a + b]
    }

    /**
     * Removes the top and top-1 from the stack and replaces it with stack[top-1]-stack[top]
     */
    public function subtract()
    {
        if ($this->stack->count() < 2) {
            throw new EmptyStackException;
        }

        // [..., a, b]
        $b = $this->pop();
        $a = $this->pop();

        $this->push($a - $b);
        // [..., a - b]
    }

    /**
     * Removes the top and top-1 from the stack and replaces it with stack[top-1]*stack[top]
     */
    public function multiply()
    {
        if ($this->stack->count() < 2) {
            throw new EmptyStackException;
        }

        // [..., a, b]
        $b = $this->pop();
        $a = $this->pop();

        $this->push($a * $b);
        // [..., a * b]
    }

    /**
     * Removes the top and top-1 from the stack and replaces it with stack[top-1]/stack[top]
     */
    public function divide()
    {
        if ($this->stack->count() < 2) {
            throw new EmptyStackException;
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