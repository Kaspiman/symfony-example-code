<?php

declare(strict_types=1);

namespace App\User\Domain\Model;

/*
 * Only interface, realization in Infrastructure folder
 */
interface UserRepository
{
    public function findById(int $id): ?User;

    public function findByUsername(string $username): ?User;

    public function save(User $user): void;
}
