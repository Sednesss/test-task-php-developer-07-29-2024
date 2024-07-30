<?php

namespace App\Services\Models;

use App\DTO\Models\UserDTO;
use App\Exceptions\Models\UserNotFoundException;
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
     * @throws UniqueConstraintViolationException
     */
    public function create(UserDTO $userDTO)
    {
        $this->model->create($userDTO->toArray());
    }

    /**
     * @throws UserNotFoundException
     * @throws UniqueConstraintViolationException
     */
    public function update(UserDTO $userDTO)
    {
        $user = $this->find($userDTO->id);
        $user->update($userDTO->toArray());
    }

    /**
     * @throws UserNotFoundException
     */
    public function delete(string $id)
    {
        $user = $this->find($id);
        $user->delete($user->id);
    }

    /**
     * @throws UserNotFoundException
     */
    public function getRoles(string $id): Collection
    {
        $user = $this->find($id);
        return $user->roles;
    }
}
