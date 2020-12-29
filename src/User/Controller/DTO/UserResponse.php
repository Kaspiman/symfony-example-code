<?php

declare(strict_types=1);

namespace App\User\Controller\DTO;

use App\User\Domain\Model\User;
use DateTimeInterface;

/**
 * @psalm-immutable
 * @see This DTO contains only allowed fields that can be returner to user
 * (without password or any other secret field)
 */
final class UserResponse
{
    public int $id;

    public string $username;

    public DateTimeInterface $createdAt;

    private function __construct()
    {
    }

    /*
     * @see classic factory method
     */
    public static function createFromUser(User $user): self
    {
        $self = new self();

        $self->id = $user->getId();
        $self->username = $user->getUsername();
        $self->createdAt = $user->getCreatedAt();

        return $self;
    }
}
