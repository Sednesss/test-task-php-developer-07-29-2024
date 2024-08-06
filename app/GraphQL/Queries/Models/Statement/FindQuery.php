<?php

declare(strict_types=1);

namespace App\GraphQL\Queries\Models\Statement;

use App\Exceptions\BaseException;
use App\Services\Models\StatementService;
use Illuminate\Support\Facades\Log;

final readonly class FindQuery
{
    protected StatementService $statementService;

    public function __construct(StatementService $statementService)
    {
        $this->statementService = $statementService;
    }

    /** @param  array{}  $args */
    public function __invoke(null $_, array $args): array
    {
        $id = $args['id'];

        try {
            $statement = $this->statementService->find($id);
        } catch (BaseException $e) {
            Log::error('GraphQL\Queries\Models\Statement\FindQuery::' . $e->getMessageCode() . ': ' . $e->getMessage()
                . ' [id:' . $id . ']');
        }

        return $statement->toArray();
    }
}
