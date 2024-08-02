<?php

namespace Tests\Feature\API\V1\Auth;

use App\DTO\Models\UserDTO;
use App\Enums\Models\UserRolesEnum;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterTest extends AuthTestCase
{
    use RefreshDatabase;

    private string $endpointPrefix;

    public function setUp(): void
    {
        $this->endpointPrefix = 'register';

        parent::setUp();
    }

    public function testSuccessfulCompletion()
    {
        $user = User::factory([
            'email_verified_at' => null,
            'phone' => null,
            'date_of_birth' => null,
            'address' => null
        ])->make();
        $userDTO = UserDTO::from($user->toArray());

        $response = $this->post($this->urlPrefix . $this->endpointPrefix, [
            'name' => $userDTO->name,
            'first_name' => $userDTO->first_name,
            'last_name' => $userDTO->last_name,
            'father_name' => $userDTO->father_name,
            'email' => $userDTO->email,
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => UserRolesEnum::CUSTOMER->value,
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'access_token',
                'token_type',
                'expires_in',
            ]
        ]);

        $this->assertDatabaseHas('users', $userDTO->toArray());
    }

    public function testRequiredFields()
    {
        $user = User::factory()->make();

        $response = $this->post($this->urlPrefix . $this->endpointPrefix, []);

        $response->assertStatus(422);
        $response->assertJsonStructure([
            'message',
            'errors' => [
                'name',
                'first_name',
                'last_name',
                'father_name',
                'password',
                'email',
                'role'
            ]
        ]);
    }

    public function testPasswordConfirmation()
    {
        $user = User::factory([
            'email_verified_at' => null,
            'phone' => null,
            'date_of_birth' => null,
            'address' => null
        ])->make();
        $userDTO = UserDTO::from($user->toArray());

        $response = $this->post($this->urlPrefix . $this->endpointPrefix, [
            'name' => $userDTO->name,
            'first_name' => $userDTO->first_name,
            'last_name' => $userDTO->last_name,
            'father_name' => $userDTO->father_name,
            'email' => $userDTO->email,
            'password' => 'password',
            'role' => UserRolesEnum::CUSTOMER->value,
        ]);

        $response->assertStatus(422);
        $response->assertJsonStructure([
            'message',
            'errors' => [
                'password',
            ]
        ]);
    }

    public function testExistName()
    {
        $userExist = User::factory()->create();
        $user = User::factory([
            'name' => $userExist->name,
            'email_verified_at' => null,
            'phone' => null,
            'date_of_birth' => null,
            'address' => null
        ])->make();
        $userDTO = UserDTO::from($user->toArray());

        $response = $this->post($this->urlPrefix . $this->endpointPrefix, [
            'name' => $userDTO->name,
            'first_name' => $userDTO->first_name,
            'last_name' => $userDTO->last_name,
            'father_name' => $userDTO->father_name,
            'email' => $userDTO->email,
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => UserRolesEnum::CUSTOMER->value,
        ]);

        $response->assertStatus(422);
        $response->assertJsonStructure([
            'message',
            'errors' => [
                'name',
            ]
        ]);
    }

    public function testExistEmail()
    {
        $userExist = User::factory()->create();
        $user = User::factory([
            'email' => $userExist->email,
            'email_verified_at' => null,
            'phone' => null,
            'date_of_birth' => null,
            'address' => null
        ])->make();
        $userDTO = UserDTO::from($user->toArray());

        $response = $this->post($this->urlPrefix . $this->endpointPrefix, [
            'name' => $userDTO->name,
            'first_name' => $userDTO->first_name,
            'last_name' => $userDTO->last_name,
            'father_name' => $userDTO->father_name,
            'email' => $userDTO->email,
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => UserRolesEnum::CUSTOMER->value,
        ]);

        $response->assertStatus(422);
        $response->assertJsonStructure([
            'message',
            'errors' => [
                'email',
            ]
        ]);
    }

    public function testInvalidRole()
    {
        $user = User::factory([
            'email_verified_at' => null,
            'phone' => null,
            'date_of_birth' => null,
            'address' => null
        ])->make();
        $userDTO = UserDTO::from($user->toArray());

        $response = $this->post($this->urlPrefix . $this->endpointPrefix, [
            'name' => $userDTO->name,
            'first_name' => $userDTO->first_name,
            'last_name' => $userDTO->last_name,
            'father_name' => $userDTO->father_name,
            'email' => $userDTO->email,
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => 'invalid_role',
        ]);

        $response->assertStatus(422);
        $response->assertJsonStructure([
            'message',
            'errors' => [
                'role',
            ]
        ]);
    }
}
