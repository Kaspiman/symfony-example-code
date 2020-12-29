<?php

declare(strict_types=1);

namespace App\Shared\Test;

use ApiTestCase\JsonApiTestCase;
use ReflectionClass;
use Symfony\Component\HttpFoundation\Response;

abstract class FunctionalTestCase extends JsonApiTestCase
{
    protected function setUp(): void
    {
        $this->expectedResponsesPath = dirname((new ReflectionClass(static::class))->getFileName());

        parent::setUp();
    }

    protected function request(
        string $method,
        string $uri,
        array $parameters = [],
        ?array $jsonContent = null
    ): Response {
        $content = null;

        if ($jsonContent) {
            $content = json_encode($jsonContent, JSON_THROW_ON_ERROR);
        }

        $this->client->request(
            $method,
            $uri,
            $parameters,
            [],
            [
                'CONTENT_TYPE' => 'application/json',
            ],
            $content
        );

        return $this->client->getResponse();
    }
}
