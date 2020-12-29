<?php

declare(strict_types=1);

namespace App\User\Controller;

use App\Shared\Controller\Action;
use App\User\Application\Query\FindUserByIdQuery;
use App\User\Controller\DTO\UserResponse;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 *
 * @Route(path="/{id}", methods={"GET"}, requirements={"id"="\d+"})
 *
 * @OA\Tag(name="User")
 *
 * @OA\Response(
 *     response=Response::HTTP_OK,
 *     description="OK",
 *     @Model(type=UserResponse::class)
 * )
 *
 * @OA\Response(
 *     response=Response::HTTP_NOT_FOUND,
 *     description="User not found"
 * )
 */
final class FindByIdAction extends Action
{
    public function __invoke(int $id): UserResponse
    {
        $user = $this->ask(new FindUserByIdQuery($id));

        return UserResponse::createFromUser($user);
    }
}
