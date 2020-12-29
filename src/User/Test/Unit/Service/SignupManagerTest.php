<?php

declare(strict_types=1);

namespace App\User\Test\Unit\Service;

use App\Shared\Test\UnitTestCase;
use App\User\Domain\Exception\PasswordStrengthException;
use App\User\Domain\Exception\UsernameInvalidException;
use App\User\Domain\Model\UserRepository;
use App\User\Domain\Service\PasswordValidator;
use App\User\Domain\Service\SignupManager;
use App\User\Domain\Service\UserFactory;
use App\User\Domain\Service\UsernameValidator;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationList;

final class SignupManagerTest extends UnitTestCase
{
    /**
     * @doesNotPerformAssertions
     */
    public function test_signup_success()
    {
        $usernameValidator = $this->createMock(UsernameValidator::class);
        $passwordValidator = $this->createMock(PasswordValidator::class);
        $userFactory = $this->createMock(UserFactory::class);
        $userRepository = $this->createMock(UserRepository::class);

        $signupManager = new SignupManager($usernameValidator, $passwordValidator, $userFactory, $userRepository);

        $signupManager->signup('user@email.com', 'passwd1');
    }

    public function test_signup_username_validation_failed()
    {
        $this->expectException(UsernameInvalidException::class);

        $usernameValidator = $this->createMock(UsernameValidator::class);

        $usernameValidator
            ->method('validate')
            ->willReturn(
                new ConstraintViolationList([$this->createMock(ConstraintViolationInterface::class)])
            );

        $passwordValidator = $this->createMock(PasswordValidator::class);
        $userFactory = $this->createMock(UserFactory::class);
        $userRepository = $this->createMock(UserRepository::class);

        $signupManager = new SignupManager($usernameValidator, $passwordValidator, $userFactory, $userRepository);

        $signupManager->signup('user@email.com', 'passwd1');
    }

    public function test_signup_password_validation_failed()
    {
        $this->expectException(PasswordStrengthException::class);

        $usernameValidator = $this->createMock(UsernameValidator::class);

        $passwordValidator = $this->createMock(PasswordValidator::class);

        $passwordValidator
            ->method('validate')
            ->willReturn(
                new ConstraintViolationList([$this->createMock(ConstraintViolationInterface::class)])
            );

        $userFactory = $this->createMock(UserFactory::class);
        $userRepository = $this->createMock(UserRepository::class);

        $signupManager = new SignupManager($usernameValidator, $passwordValidator, $userFactory, $userRepository);

        $signupManager->signup('user@email.com', 'passwd1');
    }
}
