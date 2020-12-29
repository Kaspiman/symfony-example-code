<?php

declare(strict_types=1);

namespace App\User\Application\Query;

use App\Shared\Application\Query\Query;

/**
 * @psalm-immutable
 */
final class FindUserByIdQuery implements Query
{
    public int $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }
}
