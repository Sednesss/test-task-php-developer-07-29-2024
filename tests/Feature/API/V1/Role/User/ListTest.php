<?php

namespace Tests\Feature\API\V1\Role\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ListTest extends TestCase
{
    use RefreshDatabase;

    private string $urlPrefix;
    private string $endpointPrefix;

    public function setUp(): void
    {
        $this->urlPrefix = '/api/v1/users/roles/';
        $this->endpointPrefix = 'list';

        $this->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ]);

        parent::setUp();
    }

    public function testSuccessfulCompletion()
    {
        $response = $this->get($this->urlPrefix . $this->endpointPrefix);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'roles' => [
                    0,
                    1
                ]
            ]
        ]);
    }
}
