<?php


namespace App\Validator;


class LessonHoursValidator extends AbstractValidator
{

    private $hourEnd;

    public function __construct(string $hourStart, string $hourEnd)
    {
        $this->hourEnd = $hourEnd;
        parent::__construct($hourStart);
    }

    public function validate(): bool
    {
        $hourStart = str_replace(':', '', $this->value);
        $hourEnd = str_replace(':', '', $this->hourEnd);
        return $hourStart < $hourEnd;
    }

    public function getError(): string
    {
        return "L'heure de début doit être plus petite que l'heure de fin";
    }

}