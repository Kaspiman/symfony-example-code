<?php

declare(strict_types=1);

namespace App\User\Domain\Exception;

use App\Shared\Domain\Exception\InvalidInputDataException;

final class UsernameInvalidException extends InvalidInputDataException
{
    protected function errorMessage(): string
    {
        return 'Username is invalid';
    }
}
