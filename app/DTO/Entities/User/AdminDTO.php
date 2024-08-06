<?php

namespace App\DTO\Entities\User;

use App\DTO\Models\UserDTO;

class AdminDTO extends UserAttributesDTO
{
    public function asUserDTO(): UserDTO
    {
        $adminDTOAsArray = $this->toArray();

        if ($this->id == null) {
            unset($adminDTOAsArray['id']);
        }

        return UserDTO::from($adminDTOAsArray);
    }
}
