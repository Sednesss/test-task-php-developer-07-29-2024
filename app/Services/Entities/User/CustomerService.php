<?php

namespace App\Services\Entities\User;

use App\DTO\Entities\User\CustomerDTO;
use App\Enums\Models\UserRolesEnum;
use App\Exceptions\Models\User\UserIsNotCustomerException;
use App\Exceptions\Models\User\UserNotFoundException;
use App\Models\User;
use App\Services\Models\UserService;
use Illuminate\Database\Eloquent\Collection;
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
     * @throws UserIsNotCustomerException
     */
    public function find(string $customerId): User
    {
        $user = $this->userService->find($customerId);

        if (!$this->isCustomer($user)) {
            throw new UserIsNotCustomerException();
        }

        return $user;
    }

    /**
     * @return Collection|User[]
     */
    public function list(): Collection
    {
        return $this->userService->list(UserRolesEnum::CUSTOMER);
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
     * @throws UserIsNotCustomerException
     * @throws UniqueConstraintViolationException
     */
    public function update(CustomerDTO $customerDTO): User
    {
        $user = $this->userService->find($customerDTO->id);

        if (!$this->isCustomer($user)) {
            throw new UserIsNotCustomerException();
        }

        return $this->userService->update($customerDTO->asUserDTO());
    }

    /**
     * @throws UserNotFoundException
     */
    public function delete(string $customerId)
    {
        $user = $this->userService->find($customerId);

        if (!$this->isCustomer($user)) {
            throw new UserIsNotCustomerException();
        }

        $this->userService->delete($customerId);
    }
}
