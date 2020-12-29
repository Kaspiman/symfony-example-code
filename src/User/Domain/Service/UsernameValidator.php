<?php

declare(strict_types=1);

namespace App\User\Domain\Service;

use App\User\Domain\Model\UserRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UsernameValidator
{
    private ValidatorInterface $validator;

    private UserRepository $repository;

    public function __construct(ValidatorInterface $validator, UserRepository $repository)
    {
        $this->validator = $validator;
        $this->repository = $repository;
    }

    public function validate(string $username): ConstraintViolationListInterface
    {
        // @see our business rules for username is here
        return $this->validator
            ->startContext()
            ->atPath('username')
            ->validate(
                $username,
                [
                    new Assert\NotBlank(null, 'Username is empty'),
                    new Assert\Email(null, 'Username is not valid email'),
                    new Assert\Callback(
                        function ($value, ExecutionContextInterface $context) {
                            if ($this->repository->findByUsername($value)) {
                                $context
                                    ->buildViolation('Username already exists')
                                    ->addViolation();
                            }
                        }
                    ),
                ]
            )
            ->getViolations();
    }
}
