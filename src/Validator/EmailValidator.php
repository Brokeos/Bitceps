<?php


namespace App\Validator;


class EmailValidator extends AbstractValidator
{

    public function validate(): bool
    {
        return filter_var($this->value, FILTER_VALIDATE_EMAIL);
    }

    public function getError(): string
    {
        return "Adresse email invalide";
    }

}