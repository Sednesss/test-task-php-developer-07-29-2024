<?php

namespace Tests\Feature\API\V1\Auth;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RefreshTest extends AuthTestCase
{
    use RefreshDatabase;

    private string $endpointPrefix;

    public function setUp(): void
    {
        $this->endpointPrefix = 'refresh';

        $this->withHeaders([
            'Content-Type' => 'application/json'
        ]);

        parent::setUp();
    }

    public function testSuccessfulCompletion()
    {
        /** @var Authenticatable $user */
        $user = User::factory()->create();
        $token = auth()->login($user);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->post($this->urlPrefix . $this->endpointPrefix);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'access_token',
                'token_type',
                'expires_in',
            ]
        ]);
    }

    public function testUnauthorized()
    {
        $response = $this->post($this->urlPrefix . $this->endpointPrefix);

        $response->assertStatus(401);
        $response->assertJsonStructure([
            'message'
        ]);
    }
}
