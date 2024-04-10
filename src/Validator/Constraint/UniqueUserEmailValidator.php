<?php

namespace App\Validator\Constraint;

use App\Dto\Request\UserRequest;
use App\Repository\UserRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class UniqueUserEmailValidator extends ConstraintValidator
{
    public function __construct(private readonly UserRepository $userRepository)
    {
    }

    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof UniqueUserEmail) {
            throw new UnexpectedTypeException($constraint, UniqueUserEmail::class);
        }
        if (empty($value)) {
            return;
        }

        if (!is_string($value)) {
            throw new UnexpectedValueException($value, 'string');
        }

        $group = $this->context->getGroup();
        $object = $this->context->getObject();

        if ($group === UserRequest::GROUP_CREATE) {
            if (!$this->userRepository->isUserWithThisEmailExists($value)) {
                return;
            }
        }

        if ($group === UserRequest::GROUP_UPDATE) {
            if (!$this->userRepository->isUserWithThisEmailExists($value, $object->getId())) {
                return;
            }
        }

        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ email }}', $value)
            ->addViolation();
    }
}