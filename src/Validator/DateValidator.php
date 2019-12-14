<?php


namespace App\Validator;


use DateTime;

class DateValidator extends AbstractValidator
{

    private $field;
    private $type;

    public function __construct($value, string $field, string $type)
    {
        $this->field = $field;
        $this->type = $type;
        parent::__construct($value);
    }

    public function validate(): bool
    {
        return DateTime::createFromFormat('Y-m-d', $this->value) !== false;
    }

    public function getError(): string
    {
        switch($this->type)
        {
            case 'f':
                return "La {$this->field} n'a pas une valeur correcte";
            case 'o':
                return "L'{$this->field} n'a pas une valeur correcte";
        }
        return "Le {$this->field} n'a pas une valeur correcte";
    }
}