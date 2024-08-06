<?php

namespace Database\Factories;

use App\Enums\Models\StatementCategoryEnum;
use App\Enums\Models\StatementStateEnum;
use App\Enums\Models\UserRolesEnum;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Statement>
 */
class StatementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $customer = User::factory()->create();
        $customer->assignRole(UserRolesEnum::CUSTOMER);

        return [
            'user_id' => $customer->id,
            'number' => 1,
            'category' => fake()->randomElement(array_column(StatementCategoryEnum::cases(), 'value')),
            'title' => fake()->jobTitle(),
            'state' => StatementStateEnum::STARTED->value,
            'content' => fake()->text(),
            'date' => fake()->date('Y-m-d', 'now'),
            'file' => null,
            'deleted_at' => null
        ];
    }
}
