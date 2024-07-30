<?php

namespace App\Exceptions;

use Exception;

class BaseException extends Exception
{
    protected array $args;

    public function __construct(string $message = '', array $args = [])
    {
        if (empty($message)) {
            $message = 'unknown_error';
        }

        $this->args = $args;

        parent::__construct($message);
    }
}
