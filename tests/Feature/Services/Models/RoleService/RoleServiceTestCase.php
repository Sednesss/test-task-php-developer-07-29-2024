<?php

namespace Tests\Feature\Services\Models\RoleService;

use App\Services\Models\RoleService;
use Faker\Factory as Faker;
use Faker\Generator;
use Tests\TestCase;

class RoleServiceTestCase extends TestCase
{
    protected RoleService $roleService;
    protected Generator $faker;

    public function setUp(): void
    {
        parent::setUp();

        $this->roleService = resolve(RoleService::class);
        $this->faker = Faker::create();
    }
}
