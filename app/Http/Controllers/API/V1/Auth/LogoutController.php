<?php

namespace App\Http\Controllers\API\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Auth\LogoutRequest;
use App\Http\Resources\Auth\LogoutResource;
use Illuminate\Support\Facades\Session;

class LogoutController extends Controller
{
    public function __invoke(LogoutRequest $request): LogoutResource
    {
        auth()->logout();
        Session::flush();

        return new LogoutResource([]);
    }
}
