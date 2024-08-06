<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations\Models\Statement;

use App\Exceptions\BaseException;
use App\Services\Models\StatementService;
use Illuminate\Support\Facades\Log;

final readonly class DeleteMutation
{
    protected StatementService $statementService;

    public function __construct(StatementService $statementService)
    {
        $this->statementService = $statementService;
    }
    /** @param  array{}  $args */
    public function __invoke(null $_, array $args)
    {
        try {
            $this->statementService->delete($args['input']['id']);
        } catch (BaseException $e) {
            Log::error('GraphQL\Mutations\Models\Statement\DeleteMutation::' . $e->getMessageCode() . ': ' . $e->getMessage());

            return [
                'message' => $e->getMessage()
            ];
        }

        return [
            'message' => 'Successful statement deletion'
        ];
    }
}
