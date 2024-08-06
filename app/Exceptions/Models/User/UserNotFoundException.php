<?php

namespace App\Exceptions\Models\User;

use App\Exceptions\BaseException;

class UserNotFoundException extends BaseException
{
    public function __construct(string $message = '', array $args = [])
    {
        $message = $message ?: 'User not found in the database.';
        $messageCode = 'USER_NOT_FOUND';

        parent::__construct($message, $args, $messageCode);
    }
}
