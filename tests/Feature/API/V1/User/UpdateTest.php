<?php

namespace Tests\Feature\API\V1\User;

use App\Enums\Models\UserRolesEnum;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateTest extends UserTestCase
{
    use RefreshDatabase;

    private string $endpointPrefix;

    public function setUp(): void
    {
        $this->endpointPrefix = '';
        
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
        ])->put($this->urlPrefix . $this->endpointPrefix . $user->id, [
            'name' => 'test_name',
            'first_name' => 'test_first_name',
            'last_name' => 'test_last_name',
            'father_name' => 'test_father_name',
            'email' => 'test_email',
            'phone' => 'test_phone',
            'date_of_birth' => '01.01.2000',
            'address' => 'test_address',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'user' => [
                    'id',
                    'name',
                    'email',
                    'email_verified_at',
                    'first_name',
                    'last_name',
                    'father_name',
                    'phone',
                    'date_of_birth',
                    'address',
                    'role',
                    'created_at',
                    'updated_at',
                ],
            ]
        ]);
        $response->assertJson([
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'name' => 'test_name',
                    'email' => 'test_email',
                    'first_name' => 'test_first_name',
                    'last_name' => 'test_last_name',
                    'father_name' => 'test_father_name',
                    'phone' => 'test_phone',
                    'date_of_birth' => '2000-01-01T00:00:00.000000Z',
                    'address' => 'test_address',
                    'role' => UserRolesEnum::ADMIN->value,
                ],
            ]
        ]);
    }

    public function testUnauthorized()
    {
        $user = User::factory()->create();
        $user->assignRole(UserRolesEnum::ADMIN);

        $response = $this->put($this->urlPrefix . $this->endpointPrefix . $user->id, [
            'name' => 'test_name',
            'first_name' => 'test_first_name',
            'last_name' => 'test_last_name',
            'father_name' => 'test_father_name',
            'email' => 'test_email',
            'phone' => 'test_phone',
            'date_of_birth' => '01.01.2000',
            'address' => 'test_address',
        ]);

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
        ])->put(
            $this->urlPrefix . $this->endpointPrefix . $randomId,
            [
                'name' => 'test_name',
                'first_name' => 'test_first_name',
                'last_name' => 'test_last_name',
                'father_name' => 'test_father_name',
                'email' => 'test_email',
                'phone' => 'test_phone',
                'date_of_birth' => '01.01.2000',
                'address' => 'test_address',
            ]
        );

        $response->assertStatus(404);
        $response->assertJsonStructure([
            'data' => [
                'message',
                'error'
            ]
        ]);
    }

    public function testNotUniqueField()
    {
        $userExist = User::factory()->create();
        $userExist->assignRole(UserRolesEnum::ADMIN);

        /** @var User $user */
        $user = User::factory()->create();
        $user->assignRole(UserRolesEnum::ADMIN);

        $token = auth()->login($user);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->put(
            $this->urlPrefix . $this->endpointPrefix . $user->id,
            [
                'name' => $userExist->name,
                'first_name' => 'test_first_name',
                'last_name' => 'test_last_name',
                'father_name' => 'test_father_name',
                'email' => $userExist->email,
                'phone' => 'test_phone',
                'date_of_birth' => '01.01.2000',
                'address' => 'test_address',
            ]
        );

        $response->assertStatus(404);
        $response->assertJsonStructure([
            'data' => [
                'message',
                'error'
            ]
        ]);
    }
}
