<?php

namespace App\Validator;

abstract class AbstractValidator
{

    protected $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    abstract public function validate(): bool;
    abstract public function getError(): string;

}