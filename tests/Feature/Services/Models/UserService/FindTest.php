<?php

namespace Tests\Feature\Services\Models\UserService;

use App\Exceptions\Models\UserNotFoundException;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Services\Models\UserService\UserServiceTestCase;

class FindTest extends UserServiceTestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function testSuccessfulCompletion()
    {
        $user = User::factory()->create();

        $userFind = $this->userService->find($user->id);

        $this->assertEquals($user->toArray(), $userFind->toArray());
    }

    public function testUserNotFoundException()
    {
        $user = User::factory()->create();

        do {
            $randomId = rand();
        } while ($randomId == $user->id);

        $this->expectException(UserNotFoundException::class);

        $userFind = $this->userService->find($randomId);
    }
}
