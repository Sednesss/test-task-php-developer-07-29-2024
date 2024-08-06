<?php

namespace Tests\Feature\API\V1\User;

use App\Enums\Models\UserRolesEnum;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShowTest extends UserTestCase
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
        ])->get($this->urlPrefix . $this->endpointPrefix . $user->id);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'user' => [
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
                    'role',
                ],
            ]
        ]);
    }

    public function testUnauthorized()
    {
        $user = User::factory()->create();
        $user->assignRole(UserRolesEnum::ADMIN);

        $response = $this->get($this->urlPrefix . $this->endpointPrefix . $user->id);

        $response->assertStatus(401);
        $response->assertJsonStructure([
            'message'
        ]);
    }

    public function testUserNotFoundException()
    {
        /** @var User $user */
        $user = User::factory()->create();
        $user->assignRole(UserRolesEnum::ADMIN);

        do {
            $randomId = rand();
        } while ($randomId == $user->id);

        $token = auth()->login($user);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->get($this->urlPrefix . $this->endpointPrefix . $randomId);

        $response->assertStatus(404);
        $response->assertJsonStructure([
            'data' => [
                'message'
            ]
        ]);
    }
}
