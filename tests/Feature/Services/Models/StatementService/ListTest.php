<?php

namespace Tests\Feature\Services\Models\StatementService;

use App\Enums\Models\UserRolesEnum;
use App\Models\Statement;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ListTest extends StatementServiceTestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function testSuccessfulCompletion()
    {
        $statementOther = Statement::factory()->create();

        $statementFirst = Statement::factory()->create();
        $statementSecond = Statement::factory(['user_id' => $statementFirst->user_id])->create();
        $statementThird = Statement::factory(['user_id' => $statementFirst->user_id])->create();

        $statementList = $this->statementService->list($statementFirst->user_id);

        $this->assertCount(3, $statementList);
        $this->assertFalse($statementList->contains($statementOther));
        $this->assertTrue($statementList->contains($statementSecond));
        $this->assertTrue($statementList->contains($statementThird));
        $this->assertTrue($statementList->contains($statementThird));
    }

    public function testStatementsNotExsists()
    {
        $customer = User::factory()->create();
        $customer->assignRole(UserRolesEnum::CUSTOMER);

        $statementList = $this->statementService->list($customer->id);

        $this->assertCount(0, $statementList);
    }
}
