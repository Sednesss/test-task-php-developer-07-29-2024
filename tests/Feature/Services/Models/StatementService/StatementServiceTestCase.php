<?php

namespace Tests\Feature\Services\Models\StatementService;

use App\Services\Models\StatementService;
use Faker\Factory as Faker;
use Faker\Generator;
use Tests\TestCase;

class StatementServiceTestCase extends TestCase
{
    protected StatementService $statementService;
    protected Generator $faker;

    public function setUp(): void
    {
        parent::setUp();

        $this->statementService = resolve(StatementService::class);
        $this->faker = Faker::create();
    }
}
