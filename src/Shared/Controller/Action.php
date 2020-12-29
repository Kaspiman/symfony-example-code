<?php

declare(strict_types=1);

namespace App\Shared\Controller;

use App\Shared\Application\Command\{Command, CommandBus};
use App\Shared\Application\Query\{Query, QueryBus};

/*
 * Simple and clean invokable controller action only for CQRS operations
 */
abstract class Action
{
    private QueryBus $queryBus;

    private CommandBus $commandBus;

    public function __construct(QueryBus $queryBus, CommandBus $commandBus)
    {
        $this->queryBus = $queryBus;
        $this->commandBus = $commandBus;
    }

    protected function ask(Query $query)
    {
        return $this->queryBus->ask($query);
    }

    protected function dispatch(Command $command): void
    {
        $this->commandBus->dispatch($command);
    }
}
