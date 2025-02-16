<?php

namespace App\Services\Models;

use App\DTO\Models\StatementDTO;
use App\Enums\Models\StatementCategoryEnum;
use App\Enums\Models\StatementStateEnum;
use App\Exceptions\Models\Statement\StatementNotFoundException;
use App\Exceptions\Models\User\UserIsNotCustomerException;
use App\Exceptions\Models\User\UserNotFoundException;
use App\Models\Statement;
use App\Services\Entities\User\CustomerService;
use Illuminate\Database\Eloquent\Collection;

class StatementService
{
    private Statement $model;
    private CustomerService $customerService;

    public function __construct(Statement $model, CustomerService $customerService)
    {
        $this->model = $model;
        $this->customerService = $customerService;
    }

    /**
     * @throws StatementNotFoundException
     */
    public function find(string $id): Statement
    {
        $statement = $this->model->find($id);

        if (!$statement) {
            throw new StatementNotFoundException();
        }

        return $statement;
    }

    /**
     * @throws UserNotFoundException
     * @throws UserIsNotCustomerException
     * @return Collection|Statement[]
     */
    public function list(string $customerId): Collection
    {
        $customer = $this->customerService->find($customerId);

        $statements = $customer->statements;

        return $statements;
    }

    /**
     * @throws UserNotFoundException
     * @throws UserIsNotCustomerException
     */
    public function create(StatementDTO $statementDTO): Statement
    {
        $statements = $this->list($statementDTO->user_id);
        $statementDTO->number = count($statements) + 1;

        return $this->model->create($statementDTO->toArray());
    }

    /**
     * @throws StatementNotFoundException
     * @throws UserNotFoundException
     * @throws UserIsNotCustomerException
     */
    public function update(StatementDTO $statementDTO): Statement
    {
        $statement = $this->find($statementDTO->id);
        $statementDTO->number = $statement->number;
        $statementDTO->user_id = $statementDTO->user_id ?? $statement->user_id;

        $statementDTO->category = $statementDTO->category ?? StatementCategoryEnum::from($statement->category);
        $statementDTO->title = $statementDTO->title ?? $statement->title;
        $statementDTO->content = $statementDTO->content ?? $statement->content;
        $statementDTO->state = $statementDTO->state ?? StatementStateEnum::from($statement->state);
        $statementDTO->date = $statementDTO->date ?? $statement->date;

        $customer = $this->customerService->find($statementDTO->user_id);

        $statement->update($statementDTO->toArray());
        return $statement;
    }

    /**
     * @throws StatementNotFoundException
     */
    public function delete(string $id)
    {
        $statement = $this->find($id);
        $statement->delete($statement->id);
    }

    /**
     * @return StatementCategoryEnum[]
     */
    public function listCategories(): array
    {
        return StatementCategoryEnum::cases();
    }

    /**
     * @return StatementStateEnum[]
     */
    public function listStates(): array
    {
        return StatementStateEnum::cases();
    }
}
