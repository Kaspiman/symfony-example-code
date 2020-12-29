<?php

declare(strict_types=1);

namespace App\User\Application\Query;

use App\Shared\Application\Query\Query;
use App\Shared\Controller\Request\RequestObject;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @psalm-readonly
 */
final class FindUserByUsernameQuery implements Query, RequestObject
{
    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     */
    public $username;

    private function __construct()
    {
    }

    public static function createFromString(string $username): self
    {
        $self = new self();

        $self->username = $username;

        return $self;
    }

    public static function createFromRequestPayload(
        array $requestData,
        array $queryData,
        array $attributes
    ): RequestObject {
        $self = new self();

        $self->username = $queryData['username'] ?? null;

        return $self;
    }
}
