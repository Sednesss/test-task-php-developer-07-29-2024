<?php

namespace Tests\Feature\API\V1\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends AuthTestCase
{
    use RefreshDatabase;

    private string $endpointPrefix;

    public function setUp(): void
    {
        $this->endpointPrefix = 'login';

        parent::setUp();
    }

    public function testSuccessfulCompletion()
    {
        $user = User::factory([
            'email' => 'user@example.com',
            'password' => bcrypt('password')
        ])->create();

        $response = $this->post($this->urlPrefix . $this->endpointPrefix, [
            'email' => 'user@example.com',
            'password' => 'password'
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'access_token',
                'token_type',
                'expires_in',
            ]
        ]);
    }

    public function testEmailNotExist()
    {
        $user = User::factory([
            'email' => 'user@example.com',
            'password' => bcrypt('password')
        ])->create();

        $response = $this->withHeaders([
            'Content-Type' => 'application/json'
        ])->post($this->urlPrefix . $this->endpointPrefix, [
            'email' => 'qwerty@gmail.com',
            'password' => 'password'
        ]);

        $response->assertStatus(422);
        $response->assertJsonStructure([
            'message',
            'errors' => [
                'email'
            ]
        ]);
    }

    public function testInvalidEmail()
    {
        $userExist = User::factory([
            'email' => 'qwerty@gmail.com'
        ])->create();

        $user = User::factory([
            'email' => 'user@example.com',
            'password' => bcrypt('12345')
        ])->create();

        $response = $this->post($this->urlPrefix . $this->endpointPrefix, [
            'email' => 'qwerty@gmail.com',
            'password' => '12345'
        ]);

        $response->assertStatus(401);
        $response->assertJsonStructure([
            'data'
        ]);
    }

    public function testInvalidPassword()
    {
        $user = User::factory([
            'email' => 'user@example.com',
            'password' => bcrypt('12345')
        ])->create();

        $response = $this->withHeaders([
            'Content-Type' => 'application/json'
        ])->post($this->urlPrefix . $this->endpointPrefix, [
            'email' => 'user@example.com',
            'password' => '1'
        ]);

        $response->assertStatus(422);
        $response->assertJsonStructure([
            'message',
            'errors' => [
                'password',
            ]
        ]);
    }

    public function testRequiredFields()
    {
        $user = User::factory([
            'email' => 'user@example.com',
            'password' => bcrypt('12345')
        ])->create();

        $response = $this->withHeaders([
            'Content-Type' => 'application/json'
        ])->post($this->urlPrefix . $this->endpointPrefix, []);

        $response->assertStatus(422);
        $response->assertJsonStructure([
            'message',
            'errors' => [
                'password',
                'email'
            ]
        ]);
    }
}
