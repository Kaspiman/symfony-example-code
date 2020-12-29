<?php

declare(strict_types=1);

namespace App\User\Application\Command;

use App\Shared\Application\Command\Command;
use App\Shared\Controller\Request\RequestObject;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @psalm-immutable
 */
final class SignUpCommand implements Command, RequestObject
{
    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     */
    public $username;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     */
    public $password;

    private function __construct()
    {
    }

    public static function createFromRequestPayload(
        array $requestData,
        array $queryData,
        array $attributes
    ): self {
        $self = new self();

        $self->username = $requestData['username'] ?? null;
        $self->password = $requestData['password'] ?? null;

        return $self;
    }
}
