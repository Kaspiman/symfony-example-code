<?php

namespace App\User\Domain\Service;

interface PasswordManager
{
    public function generateSalt(): string;

    public function encode(string $plainPassword, string $salt): string;
}
