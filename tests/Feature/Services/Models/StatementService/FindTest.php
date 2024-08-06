<?php

namespace Tests\Feature\Services\Models\StatementService;

use App\Exceptions\Models\Statement\StatementNotFoundException;
use App\Models\Statement;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FindTest extends StatementServiceTestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function testSuccessfulCompletion()
    {
        $statement = Statement::factory()->create();

        $statementFind = $this->statementService->find($statement->id);

        $this->assertEquals($statement->toArray(), $statementFind->toArray());
    }

    public function testStatementNotFoundException()
    {
        $statement = Statement::factory()->create();

        do {
            $randomId = rand();
        } while ($randomId == $statement->id);

        $this->expectException(StatementNotFoundException::class);

        $statementFind = $this->statementService->find($randomId);
    }
}
