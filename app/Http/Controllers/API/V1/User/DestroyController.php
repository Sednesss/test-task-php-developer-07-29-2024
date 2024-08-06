<?php

namespace App\Http\Controllers\API\V1\User;

use App\Exceptions\BaseException;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\User\DestroyRequest;
use App\Http\Resources\Default\ErrorResource;
use App\Http\Resources\User\DestroyResource;
use App\Services\Models\UserService;
use Illuminate\Support\Facades\Log;

class DestroyController extends Controller
{
    public function __invoke(
        DestroyRequest $request,
        string $userId,
        UserService $userService,
    ): DestroyResource|ErrorResource {
        try {
            $userService->delete($userId);
        } catch (BaseException $e) {
            return new ErrorResource([
                'error' => $e->getMessageCode(),
                'message' => $e->getMessage(),
                'code' => 404
            ]);

            Log::error('API\V1\User\DestroyController::' . $e->getMessageCode() . ': ' . $e->getMessage()
                . ' [id' . $userId . ']');
        }

        return new DestroyResource([]);
    }
}
