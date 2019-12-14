<?php


namespace App\Validator;


class PasswordValidator extends AbstractValidator
{

    private $confirm;

    public function __construct($value, string $confirm)
    {
        $this->confirm = $confirm;
        parent::__construct($value);
    }

    public function validate(): bool
    {
        return $this->value === $this->confirm;
    }

    public function getError(): string
    {
        return "Les mots de passes sont différents";
    }
}