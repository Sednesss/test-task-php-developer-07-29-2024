<?php

namespace App\DTO\Models;

use App\DTO\Entities\User\AdminDTO;
use App\DTO\Entities\User\CustomerDTO;
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

    public function asCustomerDTO(): CustomerDTO
    {
        return CustomerDTO::from([
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'email_verified_at' => $this->email_verified_at,
            'password' => $this->password,
            'remember_token' => $this->remember_token,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'father_name' => $this->father_name,
            'phone' => $this->phone,
            'date_of_birth' => $this->date_of_birth,
            'address' => $this->address,
        ]);
    }

    public function asAdminDTO(): AdminDTO
    {
        return AdminDTO::from([
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'email_verified_at' => $this->email_verified_at,
            'password' => $this->password,
            'remember_token' => $this->remember_token,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'father_name' => $this->father_name,
        ]);
    }
}
