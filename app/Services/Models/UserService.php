<?php

namespace App\Services\Models;

use App\DTO\Models\UserDTO;
use App\Enums\Models\UserRolesEnum;
use App\Exceptions\Models\User\UserNotFoundException;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\UniqueConstraintViolationException;

class UserService
{
    private User $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    /**
     * @throws UserNotFoundException
     */
    public function find(string $id): User
    {
        $user = $this->model->find($id);

        if (!$user) {
            throw new UserNotFoundException();
        }

        return $user;
    }

    /**
     * @return Collection|User[]
     */
    public function list(?UserRolesEnum $role): Collection
    {
        $users = $role instanceof UserRolesEnum
            ? User::role($role)->get()
            : User::all();

        return $users->load('roles');
    }

    /**
     * @throws UniqueConstraintViolationException
     */
    public function create(UserDTO $userDTO): User
    {
        return $this->model->create($userDTO->toArray());
    }

    /**
     * @throws UserNotFoundException
     * @throws UniqueConstraintViolationException
     */
    public function update(UserDTO $userDTO): User
    {
        $user = $this->find($userDTO->id);
        $user->update($userDTO->toArray());
        return $user;
    }

    /**
     * @throws UserNotFoundException
     */
    public function delete(string $id)
    {
        $user = $this->find($id);
        $user->delete($user->id);
    }
}
