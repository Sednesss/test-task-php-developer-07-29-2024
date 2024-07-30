<?php

namespace Tests\Feature\Services\Models\UserService;

use App\Exceptions\Models\UserNotFoundException;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Services\Models\UserService\UserServiceTestCase;

class DeleteTest extends UserServiceTestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function testSuccessfulCompletion()
    {
        $user = User::factory()->create();

        $this->userService->delete($user->id);

        $this->assertDatabaseMissing('users', [
            'id' => $user->id
        ]);
    }

    public function testUserNotFoundException()
    {
        $user = User::factory()->create();

        do {
            $randomId = rand();
        } while ($randomId == $user->id);

        $this->expectException(UserNotFoundException::class);

        $this->userService->delete($randomId);
    }
}
