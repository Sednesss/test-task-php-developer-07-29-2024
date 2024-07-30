<?php

namespace App\DTO\Entities\User;

use App\DTO\Models\UserDTO;

class AdminDTO extends UserAttributesDTO
{
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
            'phone' => null,
            'date_of_birth' => null,
            'address' => null,
        ]);
    }
}
