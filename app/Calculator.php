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
}