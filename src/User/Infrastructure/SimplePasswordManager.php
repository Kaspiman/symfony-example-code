<?php

declare(strict_types=1);

namespace App\User\Infrastructure;

use App\User\Domain\Model\User;
use App\User\Domain\Service\PasswordManager;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;

final class SimplePasswordManager implements PasswordManager
{
    private PasswordEncoderInterface $encoder;

    public function __construct(EncoderFactoryInterface $encoderFactory)
    {
        $this->encoder = $encoderFactory->getEncoder(User::class);
    }

    public function encode(string $plainPassword, string $salt): string
    {
        return $this->encoder->encodePassword($plainPassword, $salt);
    }

    /*
     * Just as example
     */
    public function generateSalt(): string
    {
        return (string)random_int(0, 100000);
    }
}
