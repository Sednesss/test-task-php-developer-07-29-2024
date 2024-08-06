<?php

namespace Tests\Feature\Services\Entities\User\AdminService;

use App\Enums\Models\UserRolesEnum;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IsAdminTest extends AdminServiceTestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function testCheckUserAdmin()
    {
        $user = User::factory()->create();
        $user->assignRole(UserRolesEnum::ADMIN);

        $isAdmin = $this->adminService->isAdmin($user);

        $this->assertTrue($isAdmin);
    }

    public function testCheckUserCustomer()
    {
        $user = User::factory()->create();
        $user->assignRole(UserRolesEnum::CUSTOMER);

        $isAdmin = $this->adminService->isAdmin($user);

        $this->assertFalse($isAdmin);
    }
}
