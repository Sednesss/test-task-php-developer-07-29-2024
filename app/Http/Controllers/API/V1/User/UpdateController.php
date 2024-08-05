<?php

namespace App\Http\Controllers\API\V1\User;

use App\DTO\Models\UserDTO;
use App\Exceptions\BaseException;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\User\UpdateRequest;
use App\Http\Resources\Default\ErrorResource;
use App\Http\Resources\User\UpdateResource;
use App\Services\Models\UserService;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Support\Facades\Log;

class UpdateController extends Controller
{
    public function __invoke(
        UpdateRequest $request,
        string $userId,
        UserService $userService,
    ): UpdateResource|ErrorResource {

        try {
            $user = $userService->find($userId);

            $userDTO = UserDTO::from($request->all());
            $userDTO->id = $user->id;
            $userDTO->email_verified_at = $user->email_verified_at;
            $userDTO->remember_token = $user->remember_token;
            $userDTO->password = '';

            $user = $userService->update($userDTO);
        } catch (BaseException $e) {
            return new ErrorResource([
                'error' => $e->getMessageCode(),
                'message' => $e->getMessage(),
                'code' => 404
            ]);

            Log::error('API\V1\User\UpdateController::' . $e->getMessageCode() . ': ' . $e->getMessage()
                . ' [id' . $userId . ']');
        } catch (UniqueConstraintViolationException $e) {
            return new ErrorResource([
                'error' => 'UNIQUE_CONSTRAINT_VIOLATION',
                'message' => $e->getMessage(),
                'code' => 404
            ]);

            Log::error('API\V1\User\UpdateController::' . 'UNIQUE_CONSTRAINT_VIOLATION' . ': ' . $e->getMessage()
                . ' [id' . $userId . ']');
        }

        return new UpdateResource([
            'user' => $user
        ]);
    }
}
