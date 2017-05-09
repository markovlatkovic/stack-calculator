<?php

namespace App\Exceptions;


use RuntimeException;

class StackUnderflowException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('stack underflow');
    }
}
