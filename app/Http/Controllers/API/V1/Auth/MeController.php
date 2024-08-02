<?php

namespace App\Http\Controllers\API\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Auth\MeRequest;
use App\Http\Resources\Auth\MeResource;

class MeController extends Controller
{
    public function __invoke(MeRequest $request): MeResource
    {
        return new MeResource(auth()->user());
    }
}
