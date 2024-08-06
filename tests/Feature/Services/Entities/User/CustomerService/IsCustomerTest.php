<?php

namespace Tests\Feature\Services\Entities\User\CustomerService;

use App\Enums\Models\UserRolesEnum;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IsCustomerTest extends CustomerServiceTestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function testCheckUserCustomer()
    {
        $user = User::factory()->create();
        $user->assignRole(UserRolesEnum::CUSTOMER);

        $isCustomer = $this->customerService->isCustomer($user);

        $this->assertTrue($isCustomer);
    }

    public function testCheckUserAdmin()
    {
        $user = User::factory()->create();
        $user->assignRole(UserRolesEnum::ADMIN);

        $isCustomer = $this->customerService->isCustomer($user);

        $this->assertFalse($isCustomer);
    }
}
