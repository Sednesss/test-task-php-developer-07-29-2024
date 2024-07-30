<?php

namespace Tests\Feature\Services\Entities\User\AdminService;

use App\Services\Entities\User\AdminService;
use Faker\Factory as Faker;
use Faker\Generator;
use Tests\TestCase;

class AdminServiceTestCase extends TestCase
{
    protected AdminService $adminService;
    protected Generator $faker;

    public function setUp(): void
    {
        parent::setUp();

        $this->adminService = resolve(AdminService::class);
        $this->faker = Faker::create();
    }
}
