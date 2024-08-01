<?php

namespace Tests\Feature\API\V1\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTestCase extends TestCase
{
    use RefreshDatabase;

    protected $urlPrefix = '/api/v1/auth/';

    public function setUp(): void
    {
        $this->withHeaders([
            'Accept' => 'application/json'
        ]);

        parent::setUp();
    }
}
