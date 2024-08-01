<?php

namespace Tests\Feature\Services\Models\StatementService;

use App\DTO\Models\StatementDTO;
use App\Enums\Models\StatementCategoryEnum;
use App\Enums\Models\StatementStateEnum;
use App\Enums\Models\UserRolesEnum;
use App\Exceptions\Models\User\UserIsNotCustomerException;
use App\Models\Statement;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateTest extends StatementServiceTestCase
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
        $statementDTO->category = StatementCategoryEnum::OTHER;
        $statementDTO->title = $this->faker->jobTitle();
        $statementDTO->state = StatementStateEnum::PROCESSING;
        $statementDTO->content = $this->faker->text();
        $statementDTO->date = $this->faker->date('Y-m-d', 'now');

        $statementCreate = $this->statementService->update($statementDTO);

        $this->assertDatabaseHas('statements', $statementDTO->toArray());
    }

    public function testCreatorCustomerUpdate()
    {
        $customer = User::factory()->create();
        $customer->assignRole(UserRolesEnum::CUSTOMER);

        $statement = Statement::factory()->create();
        $statementDTO = StatementDTO::from($statement->toArray());
        $statementDTO->user_id = $customer->id;

        $statementCreate = $this->statementService->update($statementDTO);

        $this->assertDatabaseHas('statements', $statementDTO->toArray());
    }

    public function testCreatorAdminUpdate()
    {
        $admin = User::factory()->create();
        $admin->assignRole(UserRolesEnum::ADMIN);

        $statement = Statement::factory()->create();
        $statementDTO = StatementDTO::from($statement->toArray());
        $statementDTO->user_id = $admin->id;

        $this->expectException(UserIsNotCustomerException::class);

        $statementCreate = $this->statementService->update($statementDTO);
    }

    public function testUpdateNumberValue()
    {
        $statement = Statement::factory()->create();
        $statementDTO = StatementDTO::from($statement->toArray());
        $statementDTO->number = 10;

        $statementCreate = $this->statementService->update($statementDTO);

        $statementDTO->number = 1;
        $this->assertDatabaseHas('statements', $statementDTO->toArray());
    }
}
