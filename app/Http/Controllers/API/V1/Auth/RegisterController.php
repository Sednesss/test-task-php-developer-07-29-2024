<?php

namespace App\Http\Controllers\API\V1\Auth;

use App\DTO\Entities\User\AdminDTO;
use App\DTO\Entities\User\CustomerDTO;
use App\Enums\Models\UserRolesEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Auth\RegisterRequest;
use App\Http\Resources\Auth\TokenInfoResource;
use App\Services\Entities\User\AdminService;
use App\Services\Entities\User\CustomerService;

class RegisterController extends Controller
{
    public function __invoke(
        RegisterRequest $request,
        CustomerService $customerService,
        AdminService $adminService
    ): TokenInfoResource {

        $user = null;
        switch ($request->role) {
            case UserRolesEnum::CUSTOMER->value:
                $customerDTO = CustomerDTO::from($request->all());
                $user = $customerService->create($customerDTO);
                break;
            case UserRolesEnum::ADMIN->value:
                $adminDTO = AdminDTO::from($request->all());
                $user = $adminService->create($adminDTO);
                break;
            default:
        }

        $token = auth()->login($user);

        return new TokenInfoResource([
            'access_token' => $token,
        ]);
    }
}
