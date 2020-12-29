<?php

declare(strict_types=1);

namespace App\User\Test\Functional\FindById;

use App\Shared\Test\FunctionalTestCase;

class FindByIdTest extends FunctionalTestCase
{
    public function test_successful()
    {
        $response = $this->request(
            'GET',
            '/api/users/1'
        );

        $this->assertResponse($response, '/Responses/user-found');
    }

    public function test_not_found()
    {
        $response = $this->request(
            'GET',
            '/api/users/123'
        );

        $this->assertResponse($response, '/Responses/not-found-error', 404);
    }
}
