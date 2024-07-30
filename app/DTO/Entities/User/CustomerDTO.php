<?php

namespace App\DTO\Entities\User;

use App\DTO\Models\UserDTO;

class CustomerDTO extends UserAttributesDTO
{
    public ?string $phone;
    public ?string $date_of_birth;
    public ?string $address;

    public function asUserDTO(): UserDTO
    {
        return UserDTO::from([
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
}
