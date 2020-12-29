<?php

declare(strict_types=1);

namespace App\User\Application\Handler;

use App\Shared\Application\Query\QueryHandler;
use App\User\Application\Query\FindUserByIdQuery;
use App\User\Domain\Exception\UserNotFoundException;
use App\User\Domain\Model\User;
use App\User\Domain\Model\UserRepository;

final class FindUserByIdHandler implements QueryHandler
{
    private UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(FindUserByIdQuery $query): User
    {
        $user = $this->repository->findById($query->id);

        if (!$user) {
            throw new UserNotFoundException();
        }

        return $user;
    }
}
