<?php

namespace App\Shared\Controller\Request;

/*
 * @see RequestObjectArgumentValueResolver
 * Interface for DTO creation
 */
interface RequestObject
{
    public static function createFromRequestPayload(array $requestData, array $queryData, array $attributes): self;
}
