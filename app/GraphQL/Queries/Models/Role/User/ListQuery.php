<?php

declare(strict_types=1);

namespace App\GraphQL\Queries\Models\Role\User;

use App\Enums\Models\UserRolesEnum;
use App\Services\Models\RoleService;

final readonly class ListQuery
{
    private RoleService $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    /** @param  array{}  $args */
    public function __invoke(null $_, array $args): array
    {
        $listRoles = $this->roleService->listUserRoles();

        return array_map(fn (UserRolesEnum $role) => $role->value, $listRoles);
    }
}
