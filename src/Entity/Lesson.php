<?php


namespace App\Entity;


use App\Kernel;

/**
 * @Table lessons
 */
class Lesson extends AbstractEntity
{

    /**
     * @Database_Field
     * @Primary
     * @Integer
     */
    protected $id;

    /**
     * @Database_Field
     * @String
     */
    protected $name;

    /**
     * @Database_Field
     * @String
     */
    protected $description;

    /**
     * @Database_Field
     * @String
     */
    protected $day;

    /**
     * @Database_Field
     * @String
     */
    protected $hourStart;

    /**
     * @Database_Field
     * @String
     */
    protected $hourEnd;

    /**
     * @Database_Field
     * @Foreign_Key App\Entity\Trainer
     * @Integer
     */
    protected $trainer_id;
    protected $trainer;
    protected $participations;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getDay(): string
    {
        return $this->day;
    }

    /**
     * @param string $day
     */
    public function setDay(string $day): void
    {
        $this->day = $day;
    }

    /**
     * @return string
     */
    public function getHourStart(): string
    {
        return $this->hourStart;
    }

    /**
     * @param string $hourStart
     */
    public function setHourStart(string $hourStart): void
    {
        $this->hourStart = $hourStart;
    }

    /**
     * @return string
     */
    public function getHourEnd(): string
    {
        return $this->hourEnd;
    }

    /**
     * @param string $hourEnd
     */
    public function setHourEnd(string $hourEnd): void
    {
        $this->hourEnd = $hourEnd;
    }

    /**
     * @return int
     */
    public function getTrainerID(): int
    {
        return $this->trainer_id;
    }

    /**
     * @param mixed $trainer_id
     */
    public function setTrainerID(int $trainer_id): void
    {
        $this->trainer_id = $trainer_id;
    }

    /**
     * @return Trainer
     */
    public function getTrainer(): Trainer
    {
        if ($this->trainer == null || $this->trainer_id != $this->trainer->getId())
        {
            $this->trainer = Kernel::getModel(Trainer::class)->getById($this->trainer_id);
        }
        return $this->trainer;
    }

    /**
     * @param Trainer $trainer
     */
    public function setTrainer(Trainer $trainer): void
    {
        $this->trainer_id = $trainer->getId();
        $this->trainer= $trainer;
    }

    /**
     * @return Participation[]
     */
    public function getParticipations(): array
    {
        if ($this->participations == null) $this->participations = Kernel::getModel(Participation::class)->getByLesson($this);
        return $this->participations;
    }

}