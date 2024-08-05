<?php

namespace App\Http\Controllers\API\V1\User;

use App\Exceptions\BaseException;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\User\ShowRequest;
use App\Http\Resources\Default\ErrorResource;
use App\Http\Resources\User\ShowResource;
use App\Services\Models\UserService;
use Illuminate\Support\Facades\Log;

class ShowController extends Controller
{
    public function __invoke(
        ShowRequest $request,
        string $userId,
        UserService $userService
    ): ShowResource|ErrorResource {
        try {
            $user = $userService->find($userId);
        } catch (BaseException $e) {

            return new ErrorResource([
                'error' => $e->getMessageCode(),
                'message' => $e->getMessage(),
                'code' => 404
            ]);

            Log::error('API\V1\User\ShowController::' . $e->getMessageCode() . ': ' . $e->getMessage()
                . ' [id' . $userId . ']');
        }

        return new ShowResource([
            'user' => $user
        ]);
    }
}
