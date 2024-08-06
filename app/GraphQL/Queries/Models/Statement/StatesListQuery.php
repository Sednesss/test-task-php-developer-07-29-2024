<?php

declare(strict_types=1);

namespace App\GraphQL\Queries\Models\Statement;

use App\Enums\Models\StatementStateEnum;
use App\Services\Models\StatementService;

final readonly class StatesListQuery
{
    protected StatementService $statementService;

    public function __construct(StatementService $statementService)
    {
        $this->statementService = $statementService;
    }

    /** @param  array{}  $args */
    public function __invoke(null $_, array $args): array
    {
        $listStates = $this->statementService->listStates();

        return array_map(fn (StatementStateEnum $catogory) => $catogory->value, $listStates);
    }
}
