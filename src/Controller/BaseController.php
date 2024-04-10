<?php

namespace App\Controller;

use App\Exceptions\ValidationException;
use App\Interfaces\DtoInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class BaseController extends AbstractController
{
    public function __construct(private readonly SerializerInterface $serializer,
                                private readonly ValidatorInterface  $validator)
    {
    }

    /**
     * @throws Exception
     */
    protected function makeDto(Request $request, string $dtoClassName, array $groups = []): DtoInterface
    {
        if (!class_exists($dtoClassName)) {
            throw new Exception('An error occurred during the execution of the request');
        }

        $dto = $this->serializer->deserialize($request->getContent(),
            $dtoClassName,
            'json',
            ['groups' => $groups]
        );

        $errorsDto = $this->validator->validate($dto, groups: $groups);

        if ($errorsDto->count() > 0) {
            $messages = [];

            foreach ($errorsDto as $error) {
                $messages[] = $error->getMessage();
            }
            throw new ValidationException($messages);
        }

        return $dto;
    }

}