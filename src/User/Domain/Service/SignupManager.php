<?php

declare(strict_types=1);

namespace App\User\Domain\Service;

use App\User\Domain\Exception\PasswordStrengthException;
use App\User\Domain\Exception\UsernameInvalidException;
use App\User\Domain\Model\UserRepository;

final class SignupManager
{
    private PasswordValidator $passwordValidator;

    private UsernameValidator $usernameValidator;

    private UserFactory $factory;

    private UserRepository $repository;

    public function __construct(
        UsernameValidator $usernameValidator,
        PasswordValidator $passwordValidator,
        UserFactory $factory,
        UserRepository $repository
    ) {
        $this->passwordValidator = $passwordValidator;
        $this->usernameValidator = $usernameValidator;
        $this->factory = $factory;
        $this->repository = $repository;
    }

    public function signup(string $username, string $password): void
    {
        $this->validateUsername($username);

        $this->validatePassword($password);

        $user = $this->factory->create($username, $password);

        $this->repository->save($user);
    }

    private function validateUsername(string $username): void
    {
        $violations = $this->usernameValidator->validate($username);

        if (count($violations) > 0) {
            throw new UsernameInvalidException($violations);
        }
    }

    private function validatePassword(string $password): void
    {
        $violations = $this->passwordValidator->validate($password);

        if (count($violations) > 0) {
            throw new PasswordStrengthException($violations);
        }
    }
}
