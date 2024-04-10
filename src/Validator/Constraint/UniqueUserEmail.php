<?php

namespace App\Validator\Constraint;

use Symfony\Component\Validator\Constraint;

#[\Attribute] class UniqueUserEmail extends Constraint
{
    public string $message = 'The email address "{{ email }}" is already in use.';

}