<?php

namespace Tests\Feature\Services\Entities\User\CustomerService;

use App\Services\Entities\User\CustomerService;
use App\Services\Models\UserService;
use Faker\Factory as Faker;
use Faker\Generator;
use Tests\TestCase;

class CustomerServiceTestCase extends TestCase
{
    protected CustomerService $customerService;
    protected Generator $faker;

    public function setUp(): void
    {
        parent::setUp();

        $this->customerService = resolve(CustomerService::class);
        $this->faker = Faker::create();
    }
}
