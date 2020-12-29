<?php

declare(strict_types=1);

namespace App\Shared\Domain\Exception;

abstract class DomainException extends \DomainException
{
    protected ?iterable $errors = null;

    public function __construct(iterable $errors = null)
    {
        $this->errors = $errors;

        parent::__construct($this->errorMessage());
    }

    public function getErrors(): ?iterable
    {
        return $this->errors;
    }

    abstract protected function errorMessage(): string;
}
