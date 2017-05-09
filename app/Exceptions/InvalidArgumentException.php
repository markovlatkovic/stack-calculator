<?php

namespace App\Exceptions;


class InvalidArgumentException extends \InvalidArgumentException
{
    public function __construct()
    {
        parent::__construct('invalid argument');
    }
}
