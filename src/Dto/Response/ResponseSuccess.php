<?php

namespace App\Dto\Response;

use Symfony\Component\HttpFoundation\JsonResponse;

class ResponseSuccess extends JsonResponse
{
    public function __construct(mixed $data = null, int $status = 200, array $headers = [], bool $json = false)
    {
        parent::__construct($data, $status, $headers, $json);
    }
}