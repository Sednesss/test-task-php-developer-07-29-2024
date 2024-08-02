<?php

namespace App\Http\Controllers\API\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Auth\LoginRequest;
use App\Http\Resources\Auth\BadCredentialsResource;
use App\Http\Resources\Auth\TokenInfoResource;

class LoginController extends Controller
{
    public function __invoke(LoginRequest $request): TokenInfoResource|BadCredentialsResource
    {
        if (!$token = auth()->attempt($request->all())) {
            return new BadCredentialsResource([]);
        }

        return new TokenInfoResource([
            'access_token' => $token,
        ]);
    }
}
