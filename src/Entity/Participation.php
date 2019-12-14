<?php


namespace App\Entity;


use App\Kernel;
use DateTime;

/**
 * @Table participations
 */
class Participation extends AbstractEntity
{

    /**
     * @Database_Field
     * @Primary
     * @Foreign_Key App\Entity\User
     * @Integer
     */
    protected $user_id;

    /**
     * @Database_Field
     * @Primary
     * @Foreign_Key App\Entity\Lesson
     * @Integer
     */
    protected $lesson_id;

    protected $user;
    protected $lesson;

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->user_id;
    }

    /**
     * @param int $user_id
     */
    public function setUserId(int $user_id): void
    {
        $this->user_id = $user_id;
    }

    /**
     * @return int
     */
    public function getLessonId(): int
    {
        return $this->lesson_id;
    }

    /**
     * @param int $lesson_id
     */
    public function setLessonId(int $lesson_id): void
    {
        $this->lesson_id = $lesson_id;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        if ($this->user == null || $this->user_id != $this->user->getId())
        {
            $this->user = Kernel::getModel(User::class)->getById($this->user_id);
        }
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user_id = $user->getId();
        $this->user = $user;
    }

    /**
     * @return Lesson
     */
    public function getLesson(): Lesson
    {
        if ($this->lesson == null || $this->lesson_id != $this->lesson->getId())
        {
            $this->lesson = Kernel::getModel(Lesson::class)->getById($this->lesson_id);
        }
        return $this->lesson;
    }

    /**
     * @param Lesson $lesson
     */
    public function setLesson(Lesson $lesson): void
    {
        $this->lesson_id = $lesson->getId();
        $this->lesson = $lesson;
    }

}