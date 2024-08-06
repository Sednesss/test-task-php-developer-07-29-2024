<?php

namespace App\Exceptions\Models\User;

use App\Exceptions\BaseException;

class UserIsNotCustomerException extends BaseException
{
    public function __construct(string $message = '', array $args = [])
    {
        $message = $message ?: 'The user does not have the role "customer".';
        $messageCode = 'USER_IS_NOT_CUSTOMER';

        parent::__construct($message, $args, $messageCode);
    }
}
