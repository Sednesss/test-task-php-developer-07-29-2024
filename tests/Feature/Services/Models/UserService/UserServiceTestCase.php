<?php

namespace Tests\Feature\Services\Models\UserService;

use App\Services\Models\UserService;
use Faker\Factory as Faker;
use Faker\Generator;
use Tests\TestCase;

class UserServiceTestCase extends TestCase
{
    protected UserService $userService;
    protected Generator $faker;

    public function setUp(): void
    {
        parent::setUp();

        $this->userService = resolve(UserService::class);
        $this->faker = Faker::create();
    }
}
