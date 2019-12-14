<?php


namespace App\Model;


use App\Entity\AbstractEntity;
use App\Entity\Lesson;
use App\Entity\Participation;
use App\Entity\User;
use App\Kernel;
use PDO;

class ParticipationModel extends Model
{

    public function __construct()
    {
        parent::__construct(Participation::class);
    }

    /**
     * @param User $user
     * @return Participation[]
     * @throws \ReflectionException
     */
    public function getByUser(User $user): array
    {
        $userForeignProperty = AbstractEntity::getEntityForeignProperty($this->entity, User::class);
        $userPrimaryProperty = $user->getPrimaryProperty();
        $query = Kernel::getDatabase()->prepare("SELECT * FROM `{$this->table}` WHERE `{$userForeignProperty->getName()}`=:{$userForeignProperty->getName()};");
        $query->bindValue($userForeignProperty->getName(), $userPrimaryProperty->getValue());
        $query->execute();
        return $query->fetchAll(PDO::FETCH_CLASS, $this->entity);
    }

    /**
     * @param Lesson $lesson
     * @return Participation[]
     * @throws \ReflectionException
     */
    public function getByLesson(Lesson $lesson): array
    {
        $lessonForeignProperty = AbstractEntity::getEntityForeignProperty($this->entity, Lesson::class);
        $lessonPrimaryProperty = $lesson->getPrimaryProperty();
        $query = Kernel::getDatabase()->prepare("SELECT * FROM `{$this->table}` WHERE `{$lessonForeignProperty->getName()}`=:{$lessonForeignProperty->getName()};");
        $query->bindValue($lessonForeignProperty->getName(), $lessonPrimaryProperty->getValue());
        $query->execute();
        return $query->fetchAll(PDO::FETCH_CLASS, $this->entity);
    }

    /**
     * @param AbstractEntity $abstractEntity
     * @return bool|\PDOStatement
     * @throws \ReflectionException
     */
    public function update(AbstractEntity $abstractEntity)
    {
        $primaryProperty = $abstractEntity->getPrimaryProperty();
        $properties = $abstractEntity->getProperties(false);
        $sql = "UPDATE `{$this->table}` SET ";
        foreach ($properties as $property)
        {
            $sql .= "`{$property->getName()}`=:{$property->getName()},";
        }
        $sql = substr($sql,0,-1);
        $sql .= " WHERE `{$primaryProperty->getName()}`=:{$primaryProperty->getName()};";
        $query = Kernel::getDatabase()->prepare($sql);
        $query->bindValue($primaryProperty->getName(), $primaryProperty->getValue());
        foreach ($properties as $property)
        {
            $query->bindValue($property->getName(), $property->getValue());
        }
        return $query->execute();
    }

    /**
     * @param AbstractEntity $abstractEntity
     * @return bool|\PDOStatement
     * @throws \ReflectionException
     */
    public function insert(AbstractEntity $abstractEntity)
    {
        $properties = $abstractEntity->getProperties(false);
        $sql = "INSERT INTO `{$this->table}` (";
        foreach ($properties as $property)
        {
            $sql .= "`{$property->getName()}`,";
        }
        $sql = substr($sql,0,-1);
        $sql.= ") VALUES (";
        foreach ($properties as $property)
        {
            $sql .= ":{$property->getName()},";
        }
        $sql = substr($sql,0,-1);
        $sql .= ");";
        $query = Kernel::getDatabase()->prepare($sql);
        foreach ($properties as $property)
        {
            $query->bindValue($property->getName(), $property->getValue());
        }
        echo $sql;
        return $query->execute();
    }

    /**
     * @param AbstractEntity $abstractEntity
     * @return bool
     * @throws \ReflectionException
     */
    public function delete(AbstractEntity $abstractEntity)
    {
        $properties = $abstractEntity->getProperties(false);
        $sql = "DELETE FROM `{$this->table}` WHERE ";
        foreach ($properties as $property)
        {
            $sql .= "`{$property->getName()}`=:{$property->getName()} AND ";
        }
        $sql = substr($sql,0,-5) . ";";
        $query = Kernel::getDatabase()->prepare($sql);
        foreach ($properties as $property)
        {
            $query->bindValue($property->getName(), $property->getValue());
        }
        return $query->execute();
    }

}