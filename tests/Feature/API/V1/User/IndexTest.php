<?php

namespace Tests\Feature\API\V1\User;

use App\Enums\Models\UserRolesEnum;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IndexTest extends UserTestCase
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
        $userFirst = User::factory()->create();
        $userFirst->assignRole(UserRolesEnum::CUSTOMER);

        /** @var User $userSecond */
        $userSecond = User::factory()->create();
        $userSecond->assignRole(UserRolesEnum::ADMIN);
        $token = auth()->login($userSecond);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->get($this->urlPrefix . $this->endpointPrefix . '');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'users' => [
                    '*' => [
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
                    ]
                ],
            ]
        ]);
    }

    public function testUnauthorized()
    {
        $response = $this->get($this->urlPrefix . $this->endpointPrefix . '');

        $response->assertStatus(401);
        $response->assertJsonStructure([
            'message'
        ]);
    }
}
