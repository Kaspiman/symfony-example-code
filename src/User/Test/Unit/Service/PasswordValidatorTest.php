<?php

declare(strict_types=1);

namespace App\User\Test\Unit\Service;

use App\Shared\Test\UnitTestCase;
use App\User\Domain\Service\PasswordValidator;

final class PasswordValidatorTest extends UnitTestCase
{
    private PasswordValidator $passwordValidator;

    protected function setUp(): void
    {
        parent::setUp();

        self::bootKernel();

        $this->passwordValidator = new PasswordValidator(self::$container->get('validator'));
    }

    public function test_validate_valid()
    {
        $violations = $this->passwordValidator->validate('pass123');

        self::assertCount(0, $violations);
    }

    public function test_validate_blank()
    {
        $violations = $this->passwordValidator->validate('');

        self::assertCount(2, $violations);
    }

    public function test_validate_short()
    {
        $violations = $this->passwordValidator->validate('pass');

        self::assertCount(1, $violations);
    }

    public function test_validate_long()
    {
        $violations = $this->passwordValidator->validate('pass1234567890');

        self::assertCount(1, $violations);
    }

    public function test_validate_simple()
    {
        $violations = $this->passwordValidator->validate('123456');

        self::assertCount(1, $violations);
    }
}
