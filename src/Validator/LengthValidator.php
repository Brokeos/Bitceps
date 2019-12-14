<?php


namespace App\Validator;


class LengthValidator extends AbstractValidator
{

    private $field;
    private $type;
    private $minLength;
    private $maxLength;

    public function __construct($value, string $field, string $type, int $minLength, int $maxLength = -1)
    {
        $this->field = $field;
        $this->type = $type;
        $this->minLength = $minLength;
        $this->maxLength = $maxLength;
        parent::__construct($value);
    }

    public function validate(): bool
    {
        if (strlen($this->value) < $this->minLength)
        {
            return false;
        } else if ($this->maxLength != -1){
            if (strlen($this->value) > $this->maxLength){
                return false;
            }
        }
        return true;
    }

    public function getError(): string
    {
        switch($this->type)
        {
            case 'f':
                return "La {$this->field} doit contenir entre {$this->minLength} et {$this->maxLength} caractères";
            case 'o':
                return "L'{$this->field} doit contenir entre {$this->minLength} et {$this->maxLength} caractères";
        }
        return "Le {$this->field} doit contenir entre {$this->minLength} et {$this->maxLength} caractères";
    }
}