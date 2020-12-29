<?php

declare(strict_types=1);

namespace App\User\Domain\Service;

use App\User\Domain\Model\User;

class UserFactory
{
    private PasswordManager $passwordManager;

    public function __construct(PasswordManager $passwordManager)
    {
        $this->passwordManager = $passwordManager;
    }

    public function create(string $username, string $password): User
    {
        $salt = $this->passwordManager->generateSalt();

        return User::create(
            $username,
            $this->passwordManager->encode($password, $salt),
            $salt
        );
    }
}
