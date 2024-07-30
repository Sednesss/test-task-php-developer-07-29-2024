<?php

namespace Tests\Feature\Services\Entities\User\CustomerService;

use App\DTO\Entities\User\CustomerDTO;
use App\Enums\Models\UserRolesEnum;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateTest extends CustomerServiceTestCase
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

        $customerDTO = CustomerDTO::from($user->toArray());
        $customerDTO->password = bcrypt('password');

        $userCreate = $this->customerService->create($customerDTO);

        $this->assertDatabaseHas('users', $customerDTO->asUserDTO()->toArray());
        $this->assertTrue($userCreate->hasAnyRole(UserRolesEnum::CUSTOMER));
    }
}
