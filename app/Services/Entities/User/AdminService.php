<?php

namespace App\Services\Entities\User;

use App\DTO\Entities\User\AdminDTO;
use App\Enums\Models\UserRolesEnum;
use App\Exceptions\Models\UserNotAdminException;
use App\Exceptions\Models\UserNotFoundException;
use App\Models\User;
use App\Services\Models\UserService;
use Illuminate\Database\UniqueConstraintViolationException;

class AdminService
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @throws UserNotFoundException
     */
    public function isAdmin(User $user): bool
    {
        return $user->hasAnyRole(UserRolesEnum::ADMIN);
    }

    /**
     * @throws UserNotFoundException
     * @throws UserNotAdminException
     */
    public function find(string $adminId): User
    {
        $user = $this->userService->find($adminId);

        if (!$this->isAdmin($user)) {
            throw new UserNotAdminException();
        }

        return $user;
    }

    /**
     * @throws UniqueConstraintViolationException
     */
    public function create(AdminDTO $adminDTO): User
    {
        $user = $this->userService->create($adminDTO->asUserDTO());
        $user->assignRole(UserRolesEnum::ADMIN);

        return $user;
    }

    /**
     * @throws UserNotFoundException
     * @throws UniqueConstraintViolationException
     */
    public function update(AdminDTO $adminDTO): User
    {
        $user = $this->userService->find($adminDTO->id);

        if (!$this->isAdmin($user)) {
            throw new UserNotAdminException();
        }

        return $this->userService->update($adminDTO->asUserDTO());
    }

    /**
     * @throws UserNotFoundException
     */
    public function delete(string $adminId)
    {
        $user = $this->userService->find($adminId);

        if (!$this->isAdmin($user)) {
            throw new UserNotAdminException();
        }

        $this->userService->delete($adminId);
    }
}
