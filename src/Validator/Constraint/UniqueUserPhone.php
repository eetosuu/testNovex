<?php

namespace App\Validator\Constraint;

use Symfony\Component\Validator\Constraint;

#[\Attribute] class UniqueUserPhone extends Constraint
{
    public string $message = 'The phone "{{ phone }}" is already in use.';

}