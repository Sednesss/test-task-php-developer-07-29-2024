<?php

namespace Tests\Feature\API\V1\User;

use App\Enums\Models\UserRolesEnum;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteTest extends UserTestCase
{
    use RefreshDatabase;

    private string $endpointPrefix;

    public function setUp(): void
    {
        $this->endpointPrefix = '';

        $this->withHeaders([
            'Content-Type' => 'application/json'
        ]);

        parent::setUp();
    }

    public function testSuccessfulCompletion()
    {
        /** @var User $user */
        $user = User::factory()->create();
        $user->assignRole(UserRolesEnum::ADMIN);

        $token = auth()->login($user);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->delete($this->urlPrefix . $this->endpointPrefix . $user->id);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'message',
            ]
        ]);

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    public function testUnauthorized()
    {
        $user = User::factory()->create();
        $user->assignRole(UserRolesEnum::ADMIN);

        $response = $this->delete($this->urlPrefix . $this->endpointPrefix . $user->id);

        $response->assertStatus(401);
        $response->assertJsonStructure([
            'message'
        ]);
    }
}
