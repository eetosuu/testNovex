<?php

namespace App\Dto\Request;

use App\Interfaces\DtoInterface;
use App\Validator\Constraint\UserExistId;
use App\Validator\Constraint\UniqueUserEmail;
use App\Validator\Constraint\UniqueUserPhone;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

class UserRequest implements DtoInterface
{
    const GROUP_CREATE = 'create';
    const GROUP_READ = 'read';
    const GROUP_UPDATE = 'update';
    const GROUP_DELETE = 'delete';
    #[Assert\NotBlank(groups: [self::GROUP_DELETE, self::GROUP_UPDATE, self::GROUP_READ])]
    #[UserExistId(groups: [self::GROUP_UPDATE, self::GROUP_READ, self::GROUP_DELETE])]
    #[Groups([self::GROUP_DELETE, self::GROUP_UPDATE, self::GROUP_READ])]
    private ?int $id = null;

    #[Assert\NotBlank(message: 'Email should not be blank.', groups: [self::GROUP_CREATE, self::GROUP_UPDATE])]
    #[Assert\Email(message: 'Email not valid.', groups: [self::GROUP_CREATE, self::GROUP_UPDATE])]
    #[UniqueUserEmail(groups: [self::GROUP_CREATE, self::GROUP_UPDATE])]
    #[Groups([self::GROUP_CREATE, self::GROUP_UPDATE])]
    private ?string $email = null;

    #[Assert\NotBlank(message: 'Name should not be blank.', groups: [self::GROUP_CREATE, self::GROUP_UPDATE])]
    #[Assert\Length(
        min: 10,
        max: 50,
        minMessage: 'Your name must be at least {{ limit }} characters long',
        maxMessage: 'Your name cannot be longer than {{ limit }} characters',
        groups: [self::GROUP_CREATE, self::GROUP_UPDATE]
    )]
    #[Groups([self::GROUP_CREATE, self::GROUP_UPDATE])]
    private ?string $name = null;

    #[Assert\NotBlank(message: 'Filed sex should not be blank.', groups: [self::GROUP_CREATE, self::GROUP_UPDATE])]
    #[Assert\Choice(
        choices: ['female', 'male'],
        message: 'Choose a valid sex.',
        groups: [self::GROUP_CREATE, self::GROUP_UPDATE]
    )]
    #[Groups([self::GROUP_CREATE, self::GROUP_UPDATE])]
    private ?string $sex = null;

    #[Assert\NotBlank(message: 'Phone should not be blank.', groups: [self::GROUP_CREATE, self::GROUP_UPDATE])]
    #[Assert\Regex(
        pattern: '/^((\+7)+([0-9]){10})$/',
        message: 'Your phone number is invalid.',
        match: true,
        groups: [self::GROUP_CREATE, self::GROUP_UPDATE]
    )]
    #[Groups([self::GROUP_CREATE, self::GROUP_UPDATE, self::GROUP_READ])]
    #[UniqueUserPhone(groups: [self::GROUP_CREATE, self::GROUP_UPDATE])]
    private ?string $phone = null;

    #[Assert\Date(message: 'Birthday should be date.', groups: [self::GROUP_CREATE, self::GROUP_UPDATE])]
    #[Assert\NotBlank(message: 'Birthday should not be blank.', groups: [self::GROUP_CREATE, self::GROUP_UPDATE])]
    #[Groups([self::GROUP_CREATE, self::GROUP_UPDATE])]
    private ?string $birthday = null;

    public function getBirthday(): ?string
    {
        return $this->birthday;
    }

    /**
     * @param string|null $birthday
     * @return UserRequest
     */
    public function setBirthday(?string $birthday): static
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
     * @return UserRequest
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
     * @return UserRequest
     */
    public function setSex(?string $sex): static
    {
        $this->sex = $sex;
        return $this;
    }


    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return UserRequest
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
     * @return UserRequest
     */
    public function setEmail(?string $email): static
    {
        $this->email = $email;
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): static
    {
        $this->id = $id;
        return $this;
    }
}