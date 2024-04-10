<?php

namespace App\Service;

use App\Entity\User;
use App\Interfaces\DtoInterface;
use App\Repository\UserRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Exception;


class UserService
{
    public function __construct(private readonly UserRepository $userRepository, private readonly EntityManagerInterface $entityManager)
    {
    }

    /**
     * @throws Exception
     * @throws ORMException
     */
    public function updateUser(DtoInterface $userRequest): User
    {
        $user = $this->userRepository->find($userRequest->getId());

        $user->setEmail($userRequest->getEmail())
            ->setSex($userRequest->getSex())
            ->setPhone($userRequest->getPhone())
            ->setName($userRequest->getName())
            ->setBirthday(new DateTime($userRequest->getBirthday()));

        $this->entityManager->flush();

        return $user;
    }

    /**
     * @throws Exception
     * @throws ORMException
     */
    public function createUser(DtoInterface $userRequest): User
    {
        $user = new User();
        $user->setEmail($userRequest->getEmail())
            ->setSex($userRequest->getSex())
            ->setPhone($userRequest->getPhone())
            ->setName($userRequest->getName())
            ->setBirthday(new DateTime($userRequest->getBirthday()));

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function deleteUser(DtoInterface $userRequest): void
    {
        $user = $this->userRepository->findOneBy(['id' => $userRequest->getId()]);

        $this->entityManager->remove($user);
        $this->entityManager->flush();
    }
}