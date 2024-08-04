<?php

namespace Tests\Feature\Services\Entities\User\CustomerService;

use App\Enums\Models\UserRolesEnum;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ListTest extends CustomerServiceTestCase
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

        $userslist = $this->customerService->list();

        $this->assertInstanceOf(Collection::class, $userslist);
        $this->assertTrue($userslist[0]->hasAnyRole(UserRolesEnum::CUSTOMER));
    }
}
