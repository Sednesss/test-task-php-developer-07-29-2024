<?php

namespace Tests\Feature\Services\Entities\User\CustomerService;

use App\DTO\Entities\User\CustomerDTO;
use App\Enums\Models\UserRolesEnum;
use App\Exceptions\Models\UserNotCustomerException;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteTest extends CustomerServiceTestCase
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
        $user->assignRole(UserRolesEnum::CUSTOMER);

        $customerDTO = CustomerDTO::from($user->toArray());

        $this->customerService->delete($customerDTO->id);

        $this->assertDatabaseMissing('users', $customerDTO->asUserDTO()->toArray());
    }

    public function testUserNotCustomerException()
    {
        $user = User::factory([
            'email_verified_at' => null,
            'password' => bcrypt('password'),
            'remember_token' => null
        ])->create();
        $user->assignRole(UserRolesEnum::ADMIN);

        $customerDTO = CustomerDTO::from($user->toArray());

        $this->expectException(UserNotCustomerException::class);

        $this->customerService->delete($customerDTO->id);
    }
}
