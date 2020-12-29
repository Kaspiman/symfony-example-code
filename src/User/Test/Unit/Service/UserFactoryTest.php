<?php

declare(strict_types=1);

namespace App\User\Test\Unit\Service;

use App\Shared\Test\UnitTestCase;
use App\User\Domain\Model\User;
use App\User\Domain\Service\PasswordManager;
use App\User\Domain\Service\UserFactory;

final class UserFactoryTest extends UnitTestCase
{
    public function test_create()
    {
        $username = 'test@email.com';
        $password = 'pass123';
        $salt = 'salt';

        $stub = $this->createMock(PasswordManager::class);

        $stub->method('generateSalt')->willReturn($salt);
        $stub->method('encode')->willReturn($password . $salt);

        $factory = new UserFactory($stub);

        $user = $factory->create($username, $password);

        self::assertInstanceOf(User::class, $user);

        self::assertEquals($username, $user->getUsername());
        self::assertEquals($password . $salt, $user->getPassword());
        self::assertEquals($salt, $user->getSalt());
    }
}
