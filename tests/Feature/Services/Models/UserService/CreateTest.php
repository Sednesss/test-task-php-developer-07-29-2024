<?php

namespace Tests\Feature\Services\Models\UserService;

use App\DTO\Models\UserDTO;
use App\Models\User;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Services\Models\UserService\UserServiceTestCase;

class CreateTest extends UserServiceTestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function testSuccessfulCompletion()
    {
        $user = User::factory()->make();
        $userDTO = UserDTO::from($user->toArray());

        $userDTO->password = bcrypt('password');
        $userDTO->email_verified_at = null;

        $userCreate = $this->userService->create($userDTO);

        $this->assertDatabaseHas('users', $userDTO->toArray());
    }

    public function testUniqueConstraintViolationException()
    {
        $user = User::factory()->create();
        $userDTO = UserDTO::from($user->toArray());

        $userDTO->password = bcrypt('password');
        $userDTO->email_verified_at = null;

        $this->expectException(UniqueConstraintViolationException::class);

        $userCreate = $this->userService->create($userDTO);
    }
}
