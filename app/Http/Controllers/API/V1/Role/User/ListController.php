<?php

namespace App\Http\Controllers\API\V1\Role\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Role\User\ListRequest;
use App\Http\Resources\Role\User\ListResource;
use App\Services\Models\RoleService;

class ListController extends Controller
{
    public function __invoke(ListRequest $request, RoleService $roleService): ListResource
    {
        $listRoles = $roleService->listUserRoles();

        return new ListResource([
            'roles' => $listRoles,
        ]);
    }
}
