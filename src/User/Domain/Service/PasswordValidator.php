<?php

declare(strict_types=1);

namespace App\User\Domain\Service;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PasswordValidator
{
    private ValidatorInterface $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function validate(string $password): ConstraintViolationListInterface
    {
        // @see our business rules for password is here
        return $this->validator
            ->startContext()
            ->atPath('password')
            ->validate(
                $password,
                [
                    new Assert\NotBlank(null, 'Password is empty'),
                    new Assert\Length(null, 6, 10, null, null, null, 'Password is too short', 'Password is too long'),
                    new Assert\Expression('value !== "123456"', 'Password is too simple'),
                ]
            )
            ->getViolations();
    }
}
