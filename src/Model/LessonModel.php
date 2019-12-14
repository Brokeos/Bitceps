<?php


namespace App\Model;


use App\Entity\AbstractEntity;
use App\Entity\Lesson;
use App\Entity\Trainer;
use App\Kernel;
use PDO;

class LessonModel extends Model
{

    public function __construct()
    {
        parent::__construct(Lesson::class);
    }

    /**
     * @return Lesson[]
     */
    public function getAll(): array
    {
        $query = Kernel::getDatabase()->query("SELECT * FROM `{$this->table}` ORDER BY hourStart;");
        return $query->fetchAll(PDO::FETCH_CLASS, $this->entity);
    }

    /**
     * @param Trainer $trainer
     * @return Lesson[]
     * @throws \ReflectionException
     */
    public function getTrainerLessons(Trainer $trainer): array
    {
        $trainerForeignProperty = AbstractEntity::getEntityForeignProperty($this->entity, Trainer::class);
        $trainerPrimaryProperty = $trainer->getPrimaryProperty();
        $query = Kernel::getDatabase()->prepare("SELECT * FROM `{$this->table}` WHERE `{$trainerForeignProperty->getName()}`=:{$trainerForeignProperty->getName()} ORDER BY hourStart;");
        $query->bindValue($trainerForeignProperty->getName(), $trainerPrimaryProperty->getValue());
        $query->execute();
        return $query->fetchAll(PDO::FETCH_CLASS, $this->entity);
    }

}