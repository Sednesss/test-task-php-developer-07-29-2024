<?php

namespace App\DTO\Entities\User;

use Spatie\LaravelData\Data;

class UserAttributesDTO extends Data
{
    public int $id;
    public string $name;
    public string $email;
    public ?string $email_verified_at;
    public string $password;
    public ?string $remember_token;

    public ?string $first_name;
    public ?string $last_name;
    public ?string $father_name;

    public ?string $created_at;
    public ?string $updated_at;
}
