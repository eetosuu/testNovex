<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class ValidationException extends Exception
{
    protected $message = 'The given params was invalid';
    protected array $errors = [];

    public function __construct(array $errors, string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        $this->errors = $errors;

        parent::__construct($message, $code, $previous);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}