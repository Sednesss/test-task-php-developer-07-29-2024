<?php

namespace Tests\Feature\Services\Models\RoleService;

use App\Enums\Models\UserRolesEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ListUserRolesTest extends RoleServiceTestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function testSuccessfulCompletion()
    {
        $listUserRoles = $this->roleService->listUserRoles();

        $this->assertIsArray($listUserRoles);
        foreach ($listUserRoles as $userRole) {
            $this->assertInstanceOf(UserRolesEnum::class, $userRole);
        }
    }
}
