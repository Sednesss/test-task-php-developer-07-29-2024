<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations\Models\Statement;

use App\DTO\Models\StatementDTO;
use App\Enums\Models\StatementCategoryEnum;
use App\Exceptions\BaseException;
use App\Services\Models\StatementService;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

final readonly class UpdateMutation
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
            $statementDTOAsArray = ['id' => $args['input']['id']];
            isset($args['input']['category']) && $statementDTOAsArray['category'] = StatementCategoryEnum::from($args['input']['category']);
            isset($args['input']['state']) && $statementDTOAsArray['state'] = $args['input']['state'];
            isset($args['input']['title']) && $statementDTOAsArray['title'] = $args['input']['title'];
            isset($args['input']['content']) && $statementDTOAsArray['content'] = $args['input']['content'];
            isset($args['input']['date']) && $statementDTOAsArray['date'] = Carbon::parse($args['input']['date'])->format('Y-m-d');

            $statementDTO = StatementDTO::from($statementDTOAsArray);

            $statement = $this->statementService->update($statementDTO);
        } catch (BaseException $e) {
            Log::error('GraphQL\Mutations\Models\Statement\UpdateMutation::' . $e->getMessageCode() . ': ' . $e->getMessage());
        }

        return $statement->toArray();
    }
}
