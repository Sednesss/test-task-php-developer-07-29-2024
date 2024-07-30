<?php

namespace Tests\Feature\Services\Entities\User\CustomerService;

use App\Enums\Models\UserRolesEnum;
use App\Exceptions\Models\UserNotCustomerException;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FindTest extends CustomerServiceTestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function testSuccessfulCompletion()
    {
        $user = User::factory()->create();
        $user->assignRole(UserRolesEnum::CUSTOMER);

        $userFind = $this->customerService->find($user->id);
        $userFindAsArray = $userFind->toArray();
        unset($userFindAsArray['roles']);

        $this->assertEquals($user->toArray(), $userFindAsArray);
    }

    public function testUserNotCustomerException()
    {
        $user = User::factory()->create();
        $user->assignRole(UserRolesEnum::ADMIN);

        $this->expectException(UserNotCustomerException::class);

        $userFind = $this->customerService->find($user->id);
    }
}
