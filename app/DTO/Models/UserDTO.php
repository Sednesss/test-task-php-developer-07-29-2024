<?php

namespace App\DTO\Models;

use Spatie\LaravelData\Data;

class UserDTO extends Data
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
    public ?string $phone;
    public ?string $date_of_birth;
    public ?string $address;

    public ?string $created_at;
    public ?string $updated_at;
}
