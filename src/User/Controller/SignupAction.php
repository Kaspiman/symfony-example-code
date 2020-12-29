<?php

declare(strict_types=1);

namespace App\User\Controller;

use App\Shared\Controller\Action;
use App\User\Application\Command\SignUpCommand;
use App\User\Application\Query\FindUserByUsernameQuery;
use App\User\Controller\DTO\UserResponse;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @see Invokable action per API method
 *
 * @Route(path="/", methods={"POST"})
 *
 * @OA\Tag(name="User")
 *
 * @OA\RequestBody(@Model(type=SignUpCommand::class))
 *
 * @OA\Response(
 *     response=JsonResponse::HTTP_OK,
 *     description="OK"
 * )
 *
 * @OA\Response(
 *     response=JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
 *     description="Signup failed"
 * )
 *
 * @OA\Response(
 *     response=JsonResponse::HTTP_BAD_REQUEST,
 *     description="Validation failed"
 * )
 */
final class SignupAction extends Action
{
    public function __invoke(SignUpCommand $command): UserResponse
    {
        $this->dispatch($command);

        $user = $this->ask(FindUserByUsernameQuery::createFromString($command->username));

        /*
         * @see No need to return User Entity, just transform it to DTO
         * No need to convert object to json, just return it.
         */
        return UserResponse::createFromUser($user);
    }
}
