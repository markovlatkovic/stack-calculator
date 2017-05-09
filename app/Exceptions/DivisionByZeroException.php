<?php

namespace App\Exceptions;


use InvalidArgumentException;

class DivisionByZeroException extends InvalidArgumentException
{
    public function __construct()
    {
        parent::__construct('division by zero');
    }
}
