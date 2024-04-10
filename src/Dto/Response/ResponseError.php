<?php

namespace App\Dto\Response;

use Symfony\Component\HttpFoundation\JsonResponse;

class ResponseError extends JsonResponse
{
    public function __construct(mixed $data = null, int $status = 500, array $headers = [], bool $json = false)
    {
        parent::__construct($data, $status, $headers, $json);
    }
}