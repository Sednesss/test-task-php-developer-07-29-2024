<?php

namespace Tests\Feature\Services\Entities\User\AdminService;

use App\DTO\Entities\User\AdminDTO;
use App\Enums\Models\UserRolesEnum;
use App\Exceptions\Models\User\UserIsNotAdminException;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateTest extends AdminServiceTestCase
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
        $adminDTO->name = $this->faker->name();
        $adminDTO->email = $this->faker->email();
        $adminDTO->password = bcrypt($this->faker->name());
        $adminDTO->first_name = $this->faker->firstName();
        $adminDTO->last_name = $this->faker->lastName();
        $adminDTO->father_name = $this->faker->firstNameMale();

        $userUpdate = $this->adminService->update($adminDTO);

        $this->assertDatabaseHas('users', $adminDTO->asUserDTO()->toArray());
    }

    public function testUserIsNotAdminException()
    {
        $user = User::factory([
            'email_verified_at' => null,
            'password' => bcrypt('password'),
            'remember_token' => null
        ])->create();
        $user->assignRole(UserRolesEnum::CUSTOMER);

        $adminDTO = AdminDTO::from($user->toArray());
        $adminDTO->name = $this->faker->name();
        $adminDTO->email = $this->faker->email();

        $this->expectException(UserIsNotAdminException::class);

        $userUpdate = $this->adminService->update($adminDTO);
    }
}
