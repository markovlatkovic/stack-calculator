<?php

namespace App;


use Illuminate\Support\Collection;

class Calculator
{
    private $stack;

    public function __construct(array $stack = [])
    {
        $this->stack = new Collection($stack);
    }

    public function peek()
    {
        return $this->stack->last();
    }
}