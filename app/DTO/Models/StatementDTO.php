<?php

namespace App\DTO\Models;

use Spatie\LaravelData\Data;

class StatementDTO extends Data
{
    public int $id;
    public string $number;
    public string $category;
    public string $title;
    public string $content;
    public string $date;
    public ?string $file;

    public ?string $created_at;
    public ?string $updated_at;
    public ?string $deleted_at;
}
