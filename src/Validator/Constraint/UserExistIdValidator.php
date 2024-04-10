<?php

namespace App\Validator\Constraint;

use App\Dto\Request\UserRequest;
use App\Repository\UserRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class UserExistIdValidator extends ConstraintValidator
{
    public function __construct(private readonly UserRepository $userRepository)
    {
    }

    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof UserExistId) {
            throw new UnexpectedTypeException($constraint, UserExistId::class);
        }

        if (!is_numeric($value)) {
            throw new UnexpectedValueException($value, 'int');
        }

        if ($this->userRepository->find(['id' => $value])) {
            return;
        }

        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ id }}', $value)
            ->addViolation();
    }
}