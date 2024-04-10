<?php

namespace App\Validator\Constraint;

use Symfony\Component\Validator\Constraint;

#[\Attribute] class UserExistId extends Constraint
{
    public string $message = 'Not found user with id "{{ id }}".';

}