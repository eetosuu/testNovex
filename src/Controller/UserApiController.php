<?php

namespace App\Controller;

use App\Dto\Request\UserRequest;
use App\Dto\Response\ResponseError;
use App\Dto\Response\ResponseSuccess;
use App\Dto\Response\UserResponse;
use App\Exceptions\ValidationException;
use App\Repository\UserRepository;
use App\Service\UserService;
use Doctrine\ORM\Exception\ORMException;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/users')]
class UserApiController extends BaseController
{
    /**
     * @throws ExceptionInterface
     */
    #[Route('/list', name: 'api_user_list', methods: ['GET'])]
    public function list(SerializerInterface $serializer, UserRepository $userRepository): JsonResponse
    {
        try {
            $users = $userRepository->findAll();

            $usersDto = [];
            foreach ($users as $user) {
                $usersDto[] = new UserResponse($user);
            }

            return new ResponseSuccess($serializer->normalize($usersDto));
        } catch (Exception $e) {
            return new ResponseError(['message' => $e->getMessage()]);
        }
    }

    #[Route('/show', name: 'api_user_show', methods: ['GET'])]
    public function show(#[MapQueryParameter] int $id, SerializerInterface $serializer,
                         UserRepository           $userRepository): JsonResponse
    {
        try {
            $user = $userRepository->findOneBy(['id' => $id]);

            if (empty($user)) {
                throw new NotFoundHttpException('User not found');
            }

            return new ResponseSuccess($serializer->normalize(new UserResponse($user)));
        } catch (ValidationException $e) {
            return new ResponseError(['message' => $e->getMessage(), 'errors' => $e->getErrors()]);
        } catch (Exception $e) {
            return new ResponseError(['message' => $e->getMessage()]);
        }
    }

    /**
     * @throws Exception|ORMException
     */
    #[Route('/create', name: 'api_user_create', methods: ['POST'])]
    public function create(Request     $request, SerializerInterface $serializer,
                           UserService $userService): JsonResponse
    {
        try {
            $userRequest = $this->makeDto($request, UserRequest::class, [UserRequest::GROUP_CREATE]);

            $user = $userService->createUser($userRequest);

            return new ResponseSuccess($serializer->normalize(new UserResponse($user)));
        } catch (ValidationException $e) {
            return new ResponseError(['message' => $e->getMessage(), 'errors' => $e->getErrors()]);
        } catch (Exception $e) {
            return new ResponseError(['message' => $e->getMessage()]);
        }
    }

    /**
     * @throws Exception|ORMException
     */
    #[Route('/update', name: 'api_user_update', methods: ['POST'])]
    public function update(Request     $request, SerializerInterface $serializer,
                           UserService $userService): JsonResponse
    {
        try {
            $userRequest = $this->makeDto($request, UserRequest::class, [UserRequest::GROUP_UPDATE]);

            $user = $userService->updateUser($userRequest);

            return new ResponseSuccess($serializer->normalize(new UserResponse($user)));
        } catch (ValidationException $e) {
            return new ResponseError(['message' => $e->getMessage(), 'errors' => $e->getErrors()]);
        } catch (Exception $e) {
            return new ResponseError(['message' => $e->getMessage()]);
        }
    }

    #[Route('/delete', name: 'api_user_delete', methods: ['POST'])]
    public function delete(Request $request, UserService $userService): JsonResponse
    {
        try {
            $userRequest = $this->makeDto($request, UserRequest::class, [UserRequest::GROUP_DELETE]);

            $userService->deleteUser($userRequest);

            return new ResponseSuccess(null, Response::HTTP_NO_CONTENT);
        } catch (ValidationException $e) {
            return new ResponseError(['message' => $e->getMessage(), 'errors' => $e->getErrors()]);
        } catch (Exception $e) {
            return new ResponseError(['message' => $e->getMessage()]);
        }
    }
}