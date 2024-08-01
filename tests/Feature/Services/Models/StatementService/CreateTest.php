<?php

namespace Tests\Feature\Services\Models\StatementService;

use App\DTO\Models\StatementDTO;
use App\Enums\Models\UserRolesEnum;
use App\Exceptions\Models\User\UserIsNotCustomerException;
use App\Models\Statement;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateTest extends StatementServiceTestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function testSuccessfulCompletion()
    {
        $statement = Statement::factory()->make();
        $statementDTO = StatementDTO::from($statement->toArray());

        $statementCreate = $this->statementService->create($statementDTO);

        $this->assertDatabaseHas('statements', $statementDTO->toArray());
    }

    public function testStatementNumber()
    {
        $statementFirst = Statement::factory()->create();
        $statementSecond = Statement::factory(['user_id' => $statementFirst->user_id])->create();

        $statement = Statement::factory(['user_id' => $statementFirst->user_id])->make();
        $statementDTO = StatementDTO::from($statement->toArray());

        $statementCreate = $this->statementService->create($statementDTO);

        $statementDTO->number = 3;
        $this->assertDatabaseHas('statements', $statementDTO->toArray());
    }

    public function testStatementNumberAfterRemoval()
    {
        $statementFirst = Statement::factory()->create();
        $statementSecond = Statement::factory(['user_id' => $statementFirst->user_id])->create();
        $statementThird = Statement::factory(['user_id' => $statementFirst->user_id])->create();
        $statementThird->delete();

        $statement = Statement::factory(['user_id' => $statementFirst->user_id])->make();
        $statementDTO = StatementDTO::from($statement->toArray());

        $statementCreate = $this->statementService->create($statementDTO);

        $statementDTO->number = 3;
        $this->assertDatabaseHas('statements', $statementDTO->toArray());
    }

    public function testAdminCreator()
    {
        $admin = User::factory()->create();
        $admin->assignRole(UserRolesEnum::ADMIN);
        $statement = Statement::factory(['user_id' => $admin->id])->make();
        $statementDTO = StatementDTO::from($statement->toArray());

        $this->expectException(UserIsNotCustomerException::class);

        $statementCreate = $this->statementService->create($statementDTO);
    }
}
