<?php

namespace Tests\Feature\GraphQL\Query\Models\Statement;

use App\Models\Statement;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Nuwave\Lighthouse\Testing\MakesGraphQLRequests;
use Nuwave\Lighthouse\Testing\RefreshesSchemaCache;
use Tests\TestCase;

class ListQueryTest extends TestCase
{
    use RefreshDatabase;
    use MakesGraphQLRequests;
    use RefreshesSchemaCache;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function testSuccessfulCompletion()
    {
        $statement = Statement::factory(['content' => 'test_content'])->create();

        $this->graphQL(
            /** @lang GraphQL */
            '
            {
                statementsFind(id: "1") {
                  id
                  user_id
                  number
                  title
                  state
                  category
                  content
                  date
                  file
                  created_at
                  updated_at
                  deleted_at
                }
              }
            '
        )->assertJsonStructure([
            'data' => [
                'statementsFind' => [
                    'id',
                    'user_id',
                    'number',
                    'title',
                    'state',
                    'category',
                    'content',
                    'date',
                    'file',
                    'created_at',
                    'updated_at',
                    'deleted_at'
                ]
            ]
        ])->assertJson([
            'data' => [
                'statementsFind' => [
                    'id' => $statement->id,
                    'user_id' => $statement->user_id,
                    'number' => $statement->number,
                    'title' => $statement->title,
                    'state' => $statement->state,
                    'category' => $statement->category,
                    'content' => $statement->content,
                    'date' => $statement->date,
                    'file' => $statement->file,
                    'created_at' => $statement->created_at,
                    'updated_at' => $statement->updated_at,
                    'deleted_at' => $statement->deleted_at
                ]
            ]
        ]);
    }
}
