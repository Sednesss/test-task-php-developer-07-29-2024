<?php

namespace Tests\Feature\Services\Entities\User\AdminService;

use App\DTO\Entities\User\AdminDTO;
use App\Enums\Models\UserRolesEnum;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateTest extends AdminServiceTestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function testSuccessfulCompletion()
    {
        $user = User::factory([
            'email_verified_at' => null
        ])->make();

        $adminDTO = AdminDTO::from($user->toArray());
        $adminDTO->password = bcrypt('password');

        $userCreate = $this->adminService->create($adminDTO);

        $this->assertDatabaseHas('users', $adminDTO->asUserDTO()->toArray());
        $this->assertTrue($userCreate->hasAnyRole(UserRolesEnum::ADMIN));
    }
}
