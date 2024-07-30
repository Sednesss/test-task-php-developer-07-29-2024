<?php

namespace Tests\Feature\Services\Entities\User\AdminService;

use App\DTO\Entities\User\AdminDTO;
use App\Enums\Models\UserRolesEnum;
use App\Exceptions\Models\UserNotAdminException;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteTest extends AdminServiceTestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function testSuccessfulCompletion()
    {
        $user = User::factory([
            'email_verified_at' => null,
            'password' => bcrypt('password'),
            'remember_token' => null
        ])->create();
        $user->assignRole(UserRolesEnum::ADMIN);

        $adminDTO = AdminDTO::from($user->toArray());

        $this->adminService->delete($adminDTO->id);

        $this->assertDatabaseMissing('users', $adminDTO->asUserDTO()->toArray());
    }

    public function testUserNotAdminException()
    {
        $user = User::factory([
            'email_verified_at' => null,
            'password' => bcrypt('password'),
            'remember_token' => null
        ])->create();
        $user->assignRole(UserRolesEnum::CUSTOMER);

        $adminDTO = AdminDTO::from($user->toArray());

        $this->expectException(UserNotAdminException::class);

        $this->adminService->delete($adminDTO->id);
    }
}
