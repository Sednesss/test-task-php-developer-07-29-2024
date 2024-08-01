<?php

namespace App\Http\Controllers\API\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Auth\RefreshRequest;
use App\Http\Resources\Auth\TokenInfoResource;

class RefreshController extends Controller
{
    public function __invoke(RefreshRequest $request): TokenInfoResource
    {
        return new TokenInfoResource([
            'access_token' => auth()->refresh(),
        ]);
    }
}
