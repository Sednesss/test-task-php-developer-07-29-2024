<?php

namespace App\DTO\Models;

use App\Enums\Models\StatementCategoryEnum;
use App\Enums\Models\StatementStateEnum;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\EnumCast;
use Spatie\LaravelData\Data;

class StatementDTO extends Data
{
    public int $id;
    public int $user_id;
    public ?string $number;
    #[WithCast(EnumCast::class, StatementCategoryEnum::class)]
    public StatementCategoryEnum $category;
    public string $title;
    #[WithCast(EnumCast::class, StatementStateEnum::class)]
    public StatementStateEnum $state;
    public string $content;
    public string $date;
    public ?string $file;

    public ?string $created_at;
    public ?string $updated_at;
    public ?string $deleted_at;
}
