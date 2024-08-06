<?php

namespace Tests\Feature\Services\Models\StatementService;

use App\Enums\Models\StatementStateEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ListStatesTest extends StatementServiceTestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function testSuccessfulCompletion()
    {
        $listStates = $this->statementService->listStates();

        $this->assertIsArray($listStates);
        foreach ($listStates as $statmentState) {
            $this->assertInstanceOf(StatementStateEnum::class, $statmentState);
        }
    }
}
