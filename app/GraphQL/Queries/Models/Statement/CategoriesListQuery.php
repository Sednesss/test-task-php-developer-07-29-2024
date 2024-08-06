<?php

declare(strict_types=1);

namespace App\GraphQL\Queries\Models\Statement;

use App\Enums\Models\StatementCategoryEnum;
use App\Services\Models\StatementService;

final readonly class CategoriesListQuery
{
    protected StatementService $statementService;

    public function __construct(StatementService $statementService)
    {
        $this->statementService = $statementService;
    }

    /** @param  array{}  $args */
    public function __invoke(null $_, array $args): array
    {
        $listCategories = $this->statementService->listCategories();

        return array_map(fn (StatementCategoryEnum $catogory) => $catogory->value, $listCategories);
    }
}
