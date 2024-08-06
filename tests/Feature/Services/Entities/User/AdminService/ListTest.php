<?php

namespace Tests\Feature\Services\Entities\User\AdminService;

use App\Enums\Models\UserRolesEnum;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ListTest extends AdminServiceTestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function testSuccessfulCompletion()
    {
        $user = User::factory()->create();
        $user->assignRole(UserRolesEnum::ADMIN);

        $userslist = $this->adminService->list();

        $this->assertInstanceOf(Collection::class, $userslist);
        $this->assertTrue($userslist[0]->hasAnyRole(UserRolesEnum::ADMIN));
    }
}
