<?php

declare(strict_types=1);

namespace App\User\Domain\Model;

use App\Shared\Domain\Model\EntityInterface;
use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @see User Doctrine Entity as Model of User Bounded Context
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface, EntityInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", nullable=false, unique=true)
     */
    private string $username;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private string $password;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private string $salt;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    private DateTimeInterface $createdAt;

    private function __construct()
    {
    }

    /*
     * @see
     * Here i restrict User creation only with username, password, and salt
     * Also see at private constructor.
     */
    public static function create(string $username, string $password, string $salt): self
    {
        $self = new self();

        $self->username = $username;
        $self->password = $password;
        $self->salt = $salt;
        $self->createdAt = new DateTimeImmutable();

        return $self;
    }

    public function getRoles(): array
    {
        return ['ROLE_USER'];
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getSalt(): string
    {
        return $this->salt;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function eraseCredentials(): void
    {
    }

    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getId(): int
    {
        return $this->id;
    }
}
