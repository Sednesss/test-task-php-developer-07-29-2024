<?php

namespace App\Services\Models;

use App\Enums\Models\UserRolesEnum;
use Spatie\Permission\Models\Role;

class RoleService
{
    private Role $model;

    public function __construct(Role $model)
    {
        $this->model = $model;
    }

    /**
     * @return UserRolesEnum[]
     */
    public function listUserRoles(): array
    {
        return UserRolesEnum::cases();
    }
}
