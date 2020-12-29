<?php

declare(strict_types=1);

namespace App\User\Domain\Exception;

use App\Shared\Domain\Exception\InvalidInputDataException;

final class PasswordStrengthException extends InvalidInputDataException
{
    protected function errorMessage(): string
    {
        return 'Password is not enough strong';
    }
}
