<?php

namespace App\Exceptions\Models;

use App\Exceptions\BaseException;

class UserNotFoundException extends BaseException
{
    public function __construct(string $message = '', array $args = [])
    {
        $message = $message ?: 'User not found in the database.';

        parent::__construct($message, $args);
    }
}
