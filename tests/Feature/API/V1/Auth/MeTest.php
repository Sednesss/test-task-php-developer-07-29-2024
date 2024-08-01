<?php

namespace Tests\Feature\API\V1\Auth;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MeTest extends AuthTestCase
{
    use RefreshDatabase;

    private $endpointPrefix;

    public function setUp(): void
    {
        $this->endpointPrefix = 'me';

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
                'id',
                'name',
                'email',
                'email_verified_at',
                'created_at',
                'updated_at',
                'first_name',
                'last_name',
                'father_name',
                'phone',
                'date_of_birth',
                'address',
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
