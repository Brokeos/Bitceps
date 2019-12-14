<?php


namespace App\Entity;


use App\Kernel;
use DateTime;
use Exception;

/**
 * @Table users
 */
class User extends AbstractEntity
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
    protected $email;

    /**
     * @Database_Field
     * @String
     */
    protected $password;

    /**
     * @Database_Field
     * @String
     */
    protected $firstname;

    /**
     * @Database_Field
     * @String
     */
    protected $lastname;

    /**
     * @Database_Field
     * @String
     */
    protected $gender;

    /**
     * @Database_Field
     * @Date
     */
    protected $birthdate;

    /**
     * @Database_Field
     * @Integer
     */
    protected $isAdmin;

    /**
     * @Database_Field
     * @Foreign_Key App\Entity\Tarif
     * @Integer
     */
    protected $subscription_id;

    protected $participations;
    protected $subscription;

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
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getFirstname(): string
    {
        return htmlspecialchars($this->firstname);
    }

    /**
     * @param string $firstname
     */
    public function setFirstname(string $firstname): void
    {
        $this->firstname = $firstname;
    }

    /**
     * @return string
     */
    public function getLastname(): string
    {
        return htmlspecialchars($this->lastname);
    }

    /**
     * @param string $lastname
     */
    public function setLastname(string $lastname): void
    {
        $this->lastname = $lastname;
    }

    /**
     * @return string
     */
    public function getGender(): string
    {
        return $this->gender;
    }

    /**
     * @param string $gender
     */
    public function setGender(string $gender): void
    {
        $this->gender = $gender;
    }

    /**
     * @return DateTime
     * @throws Exception
     */
    public function getBirthdate(): DateTime
    {
        if ($this->birthdate instanceof DateTime)
        {
            return $this->birthdate;
        } else
        {
            $this->birthdate = new DateTime($this->birthdate);
            return $this->birthdate;
        }
    }

    /**
     * @param DateTime $birthdate
     */
    public function setBirthdate(DateTime $birthdate): void
    {
        $this->birthdate = $birthdate;
    }

    /**
     * @return bool
     */
    public function getIsAdmin(): bool
    {
        return $this->isAdmin;
    }

    /**
     * @param bool $isAdmin
     */
    public function setIsAdmin(bool $isAdmin): void
    {
        $this->isAdmin = $isAdmin;
    }

    /**
     * @return int|null
     */
    public function getSubscriptionID(): ?int
    {
        return $this->subscription_id;
    }

    /**
     * @param int $subscription_id
     */
    public function setSubscriptionID(?int $subscription_id): void
    {
        $this->subscription_id = $subscription_id;
    }

    /**
     * @return Tarif|null
     */
    public function getSubscription(): ?Tarif
    {
        if ($this->subscription == null && $this->subscription_id != null) $this->subscription = Kernel::getModel(Tarif::class)->getById($this->subscription_id);
        return $this->subscription;
    }

    public function setSubscription(Tarif $subscription): void
    {
        $this->subscription_id = $subscription->getId();
        $this->subscription = $subscription;
    }

    /**
     * @return Participation[]
     */
    public function getParticipations(): array
    {
        if ($this->participations == null) $this->participations = Kernel::getModel(Participation::class)->getByUser($this);
        return $this->participations;
    }

}