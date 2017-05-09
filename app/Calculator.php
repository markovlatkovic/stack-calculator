<?php

namespace App;


use Illuminate\Support\Collection;

class Calculator
{
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
     */
    public function peek()
    {
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

    public function getStack()
    {
        return $this->stack->all();
    }
}