<?php

namespace App\Http\Controllers\API\V1\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\User\IndexRequest;
use App\Http\Resources\User\IndexResource;
use App\Services\Models\UserService;

class IndexController extends Controller
{
    public function __invoke(
        IndexRequest $request,
        UserService $userService
    ): IndexResource {

        $users = $userService->list(null);

        return new IndexResource([
            'users' => $users
        ]);
    }
}
