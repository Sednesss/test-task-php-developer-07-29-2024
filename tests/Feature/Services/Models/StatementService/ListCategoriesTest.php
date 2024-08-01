<?php

namespace Tests\Feature\Services\Models\StatementService;

use App\Enums\Models\StatementCategoryEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ListCategoriesTest extends StatementServiceTestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function testSuccessfulCompletion()
    {
        $listCategories = $this->statementService->listCategories();

        $this->assertIsArray($listCategories);
        foreach ($listCategories as $statmentCategory) {
            $this->assertInstanceOf(StatementCategoryEnum::class, $statmentCategory);
        }
    }
}
