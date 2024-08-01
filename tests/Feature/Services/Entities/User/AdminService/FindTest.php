<?php

namespace Tests\Feature\Services\Entities\User\AdminService;

use App\Enums\Models\UserRolesEnum;
use App\Exceptions\Models\User\UserIsNotAdminException;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FindTest extends AdminServiceTestCase
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

        $userFind = $this->adminService->find($user->id);
        $userFindAsArray = $userFind->toArray();
        unset($userFindAsArray['roles']);

        $this->assertEquals($user->toArray(), $userFindAsArray);
    }

    public function testUserIsNotAdminException()
    {
        $user = User::factory()->create();
        $user->assignRole(UserRolesEnum::CUSTOMER);

        $this->expectException(UserIsNotAdminException::class);

        $userFind = $this->adminService->find($user->id);
    }
}
