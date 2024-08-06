<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations\Models\Statement;

use App\DTO\Models\StatementDTO;
use App\Enums\Models\StatementCategoryEnum;
use App\Enums\Models\StatementStateEnum;
use App\Exceptions\BaseException;
use App\Services\Models\StatementService;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

final readonly class CreateMutation
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
            $statementDTO = StatementDTO::from([
                'user_id' => $args['input']['customer_id'],
                'category' => StatementCategoryEnum::from($args['input']['category']),
                'title' => $args['input']['title'],
                'state' => StatementStateEnum::STARTED,
                'content' => $args['input']['content'],
                'date' => Carbon::parse($args['input']['date'])->format('Y-m-d'),
            ]);

            $statement = $this->statementService->create($statementDTO);
        } catch (BaseException $e) {
            Log::error('GraphQL\Mutations\Models\Statement\CreateMutation::' . $e->getMessageCode() . ': ' . $e->getMessage());
        }

        return $statement->toArray();
    }
}
