<?php

namespace Tests\Feature\Services\Models\StatementService;

use App\DTO\Models\StatementDTO;
use App\Models\Statement;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteTest extends StatementServiceTestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function testSuccessfulCompletion()
    {
        $statement = Statement::factory()->create();
        $statementDTO = StatementDTO::from($statement->toArray());

        $this->statementService->delete($statementDTO->id);

        $this->assertDatabaseHas('statements', [
            'id' => $statementDTO->id,
            'deleted_at' => now() 
        ]);
    }
}
