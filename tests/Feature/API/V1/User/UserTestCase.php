<?php

namespace Tests\Feature\API\V1\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTestCase extends TestCase
{
    use RefreshDatabase;

    protected string $urlPrefix = '/api/v1/users/';

    public function setUp(): void
    {
        $this->withHeaders([
            'Accept' => 'application/json'
        ]);

        parent::setUp();
    }
}
