<?php

declare(strict_types=1);

namespace App\User\Domain\Exception;

use App\Shared\Domain\Exception\ResourceNotFoundException;

final class UserNotFoundException extends ResourceNotFoundException
{
    protected function errorMessage(): string
    {
        return 'User not found';
    }
}
