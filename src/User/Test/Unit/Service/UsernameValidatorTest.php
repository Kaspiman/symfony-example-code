<?php

declare(strict_types=1);

namespace App\User\Test\Unit\Service;

use App\Shared\Test\UnitTestCase;
use App\User\Domain\Model\User;
use App\User\Domain\Model\UserRepository;
use App\User\Domain\Service\UsernameValidator;

final class UsernameValidatorTest extends UnitTestCase
{
    private UsernameValidator $usernameValidator;

    protected function setUp(): void
    {
        parent::setUp();

        self::bootKernel();

        $repositoryStub = $this->createMock(UserRepository::class);

        $repositoryStub->method('findByUsername')->willReturnCallback(
            function ($value) {
                if ($value === 'exist@email.com') {
                    return $this->createMock(User::class);

                }

                return null;
            }
        );

        $this->usernameValidator = new UsernameValidator(self::$container->get('validator'), $repositoryStub);
    }

    public function test_validate_success()
    {
        $violations = $this->usernameValidator->validate('username@email.com');

        self::assertCount(0, $violations);
    }

    public function test_validate_non_uniq()
    {
        $violations = $this->usernameValidator->validate('exist@email.com');

        self::assertCount(1, $violations);
    }
}
