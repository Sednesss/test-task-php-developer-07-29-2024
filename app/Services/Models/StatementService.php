<?php

namespace App\Services\Models;

use App\DTO\Models\StatementDTO;
use App\Enums\Models\StatementCategoryEnum;
use App\Enums\Models\StatementStateEnum;
use App\Exceptions\Models\Statement\StatementNotFoundException;
use App\Exceptions\Models\UserIsNotCustomerException;
use App\Exceptions\Models\UserNotFoundException;
use App\Models\Statement;
use App\Services\Entities\User\CustomerService;

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
     * @return Statement[]
     */
    public function list(string $customerId): array
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
     * @throws UserNotFoundException
     * @throws UserIsNotCustomerException
     * @throws StatementNotFoundException
     */
    public function update(StatementDTO $statementDTO): Statement
    {
        $customer = $this->customerService->find($statementDTO->user_id);

        $statement = $this->find($statementDTO->id);
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
