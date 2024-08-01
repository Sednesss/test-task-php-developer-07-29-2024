<?php

namespace App\Exceptions\Models\User;

use App\Exceptions\BaseException;

class UserIsNotAdminException extends BaseException
{
    public function __construct(string $message = '', array $args = [])
    {
        $message = $message ?: 'The user does not have the role "admin".';

        parent::__construct($message, $args);
    }
}
