<?php

namespace App\Http\Controllers\API\V1\User;

use App\Enums\Models\UserRolesEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\User\IndexRequest;
use App\Http\Resources\User\IndexResource;
use App\Services\Entities\User\AdminService;
use App\Services\Entities\User\CustomerService;
use App\Services\Models\UserService;

class IndexController extends Controller
{
    public function __invoke(
        IndexRequest $request,
        CustomerService $customerService,
        AdminService $adminService,
        UserService $userService
    ): IndexResource {

        switch ($request->role) {
            case UserRolesEnum::CUSTOMER->value:
                $users = $customerService->list();
                break;
            case UserRolesEnum::ADMIN->value:
                $users = $adminService->list();
                break;
            default:
                $users = $userService->list(null);
                break;
        }

        return new IndexResource([
            'users' => $users
        ]);
    }
}
