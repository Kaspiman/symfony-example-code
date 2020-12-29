<?php

declare(strict_types=1);

namespace App\User\Application\Handler;

use App\Shared\Application\Command\CommandHandler;
use App\User\Application\Command\SignUpCommand;
use App\User\Domain\Service\SignupManager;

final class SignupCommandHandler implements CommandHandler
{
    private SignupManager $signupManager;

    public function __construct(SignupManager $signupManager)
    {
        $this->signupManager = $signupManager;
    }

    public function __invoke(SignUpCommand $query)
    {
        $this->signupManager->signup($query->username, $query->password);
    }
}
