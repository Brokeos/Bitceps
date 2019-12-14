<?php


namespace App\Entity;


use App\Kernel;

/**
 * @Table trainers
 */
class Trainer extends AbstractEntity
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
    protected $category;

    /**
     * @Database_Field
     * @String
     */
    protected $picture;

    /**
     * @Database_Field
     * @String
     */
    protected $color;

    protected $lessons;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Trainer
     */
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
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
     * @return Trainer
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getCategory(): string
    {
        return $this->category;
    }

    /**
     * @param string $category
     * @return Trainer
     */
    public function setCategory(string $category): self
    {
        $this->category = $category;
        return $this;
    }

    /**
     * @return string
     */
    public function getPicture(): string
    {
        return $this->picture;
    }

    /**
     * @param string $picture
     * @return Trainer
     */
    public function setPicture(string $picture): self
    {
        $this->picture = $picture;
        return $this;
    }

    /**
     * @return string
     */
    public function getColor(): string
    {
        return $this->color;
    }

    /**
     * @param string $color
     */
    public function setColor(string $color): void
    {
        $this->color = $color;
    }

    /**
     * @return Lesson[]
     */
    public function getLessons(): array
    {
        if ($this->lessons == null)
        {
            $this->lessons = Kernel::getModel(Lesson::class)->getTrainerLessons($this);
        }
        return $this->lessons;
    }

}