<?php

namespace Tests\Feature\Services\Models\UserService;

use App\Enums\Models\UserRolesEnum;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Services\Models\UserService\UserServiceTestCase;

class ListTest extends UserServiceTestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function testSuccessfulCompletion()
    {
        $users = User::factory()->count(5)->create();

        $usersList = $this->userService->list(null);

        $this->assertInstanceOf(Collection::class, $usersList);
        $this->assertCount(count($users) + 1, $usersList);
    }

    public function testFilterByRole()
    {
        $user = User::factory()->create();
        $user->assignRole(UserRolesEnum::CUSTOMER);
        $user->load('roles');

        $usersList = $this->userService->list(UserRolesEnum::CUSTOMER);

        $this->assertEquals($user->toArray(), $usersList[0]->toArray());
    }
}
