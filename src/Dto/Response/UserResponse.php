<?php

namespace App\Dto\Response;

use App\Entity\User;
use App\Interfaces\DtoInterface;
use DateTime;
use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

class UserResponse implements DtoInterface
{
    private int $id;
    
    private ?string $email;
    
    private ?string $name;
    
    private ?int $age;
    
    private ?string $sex;
    
    private ?string $phone;
    
    #[Context([DateTimeNormalizer::FORMAT_KEY => 'Y-m-d'])]
    private ?DateTime $birthday;

    public function __construct(User $user)
    {
        $this
            ->setId($user->getId())
            ->setEmail($user->getEmail())
            ->setName($user->getName())
            ->setAge($user->getAge())
            ->setSex($user->getSex())
            ->setPhone($user->getPhone())
            ->setBirthday($user->getBirthday());
    }

    public function getBirthday(): DateTime
    {
        return $this->birthday;
    }

    /**
     * @param DateTime|null $birthday
     * @return UserResponse
     */
    public function setBirthday(?DateTime $birthday): static
    {
        $this->birthday = $birthday;
        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @param string|null $phone
     * @return UserResponse
     */
    public function setPhone(?string $phone): static
    {
        $this->phone = $phone;
        return $this;
    }

    public function getSex(): ?string
    {
        return $this->sex;
    }

    /**
     * @param string|null $sex
     * @return UserResponse
     */
    public function setSex(?string $sex): static
    {
        $this->sex = $sex;
        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    /**
     * @param int|null $age
     * @return UserResponse
     */
    public function setAge(?int $age): static
    {
        $this->age = $age;
        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return UserResponse
     */
    public function setName(?string $name): static
    {
        $this->name = $name;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     * @return UserResponse
     */
    public function setEmail(?string $email): static
    {
        $this->email = $email;
        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return UserResponse
     */
    public function setId(int $id): static
    {
        $this->id = $id;
        return $this;
    }
}