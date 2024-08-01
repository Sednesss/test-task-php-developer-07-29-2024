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
        $customerDTOAsArray = $this->toArray();

        if ($this->id == null) {
            unset($customerDTOAsArray['id']);
        }

        return UserDTO::from($customerDTOAsArray);
    }
}
