<?php

declare(strict_types=1);

namespace App\User\Test\Functional\Signup;

use App\Shared\Test\FunctionalTestCase;

class SignupActionTest extends FunctionalTestCase
{
    public function test_signup_successful()
    {
        $response = $this->request(
            'POST',
            '/api/users/',
            [],
            ['username' => 'validUserName@gmail.com', 'password' => 'pass123']
        );

        $this->assertResponse($response, '/Responses/signup-successful');
    }

    public function test_empty_request()
    {
        $response = $this->request(
            'POST',
            '/api/users/'
        );

        $this->assertResponse($response, '/Responses/empty-request-error', 400);
    }

    public function test_wrong_username()
    {
        $response = $this->request(
            'POST',
            '/api/users/',
            [],
            ['username' => 'wrongUserName', 'password' => 'password123']
        );

        $this->assertResponse($response, '/Responses/wrong-username-error', 400);
    }

    public function test_wrong_password()
    {
        $response = $this->request(
            'POST',
            '/api/users/',
            [],
            ['username' => 'validUserName@gmail.com', 'password' => 'short']
        );

        $this->assertResponse($response, '/Responses/short-password-error', 400);

        $response = $this->request(
            'POST',
            '/api/users/',
            [],
            ['username' => 'validUserName@gmail.com', 'password' => 'longlonglong']
        );

        $this->assertResponse($response, '/Responses/long-password-error', 400);

        $response = $this->request(
            'POST',
            '/api/users/',
            [],
            ['username' => 'validUserName@gmail.com', 'password' => '123456']
        );

        $this->assertResponse($response, '/Responses/simple-password-error', 400);
    }
}
