<?php

namespace App\Http\Controllers\API\V1\Auth;

use App\DTO\Entities\User\CustomerDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Auth\RegisterRequest;
use App\Http\Resources\Auth\BadCredentialsResource;
use App\Http\Resources\Auth\TokenInfoResource;
use App\Services\Entities\User\CustomerService;

class RegisterController extends Controller
{
    public function __invoke(RegisterRequest $request, CustomerService $customerService): TokenInfoResource|BadCredentialsResource
    {
        $customerDTO = CustomerDTO::from($request->all());
        $user = $customerService->create($customerDTO);

        $token = auth()->login($user);

        return new TokenInfoResource([
            'access_token' => $token,
        ]);
    }
}
