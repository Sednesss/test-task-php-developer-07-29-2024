<?php

namespace App\Services\Entities\User;

use App\DTO\Entities\User\CustomerDTO;
use App\Enums\Models\UserRolesEnum;
use App\Exceptions\Models\UserNotCustomerException;
use App\Exceptions\Models\UserNotFoundException;
use App\Models\User;
use App\Services\Models\UserService;
use Illuminate\Database\UniqueConstraintViolationException;

class CustomerService
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @throws UserNotFoundException
     */
    public function isCustomer(User $user): bool
    {
        return $user->hasAnyRole(UserRolesEnum::CUSTOMER);
    }

    /**
     * @throws UserNotFoundException
     * @throws UserNotCustomerException
     */
    public function find(string $customerId): User
    {
        $user = $this->userService->find($customerId);

        if ($this->isCustomer($user)) {
            throw new UserNotCustomerException();
        }

        return $user;
    }

    /**
     * @throws UniqueConstraintViolationException
     */
    public function create(CustomerDTO $customerDTO): User
    {
        $user = $this->userService->create($customerDTO->asUserDTO());
        $user->assignRole(UserRolesEnum::CUSTOMER);

        return $user;
    }

    /**
     * @throws UserNotFoundException
     * @throws UniqueConstraintViolationException
     */
    public function update(CustomerDTO $customerDTO): User
    {
        return $this->userService->update($customerDTO->asUserDTO());
    }

    /**
     * @throws UserNotFoundException
     */
    public function delete(string $customerId)
    {
        $this->userService->delete($customerId);
    }
}
