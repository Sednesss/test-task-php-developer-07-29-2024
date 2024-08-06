<?php

declare(strict_types=1);

namespace App\GraphQL\Queries\Models\Statement;

use App\Exceptions\BaseException;
use App\Services\Models\StatementService;
use Illuminate\Support\Facades\Log;

final readonly class ListQuery
{
    protected StatementService $statementService;

    public function __construct(StatementService $statementService)
    {
        $this->statementService = $statementService;
    }

    /** @param  array{}  $args */
    public function __invoke(null $_, array $args): array
    {
        $userId = $args['user_id'];

        try {
            $listStatements = $this->statementService->list($userId);
        } catch (BaseException $e) {
            Log::error('GraphQL\Queries\Models\Statement\ListQuery::' . $e->getMessageCode() . ': ' . $e->getMessage()
                . ' [id:' . $userId . ']');
        }

        return $listStatements->toArray();
    }
}
