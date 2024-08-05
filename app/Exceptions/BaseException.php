<?php

namespace App\Exceptions;

use Exception;

class BaseException extends Exception
{
    protected array $args;
    protected string $messageCode;

    public function __construct(string $message = '', array $args = [], string $messageCode = '')
    {
        if (empty($message)) {
            $message = 'UNKNOWN_ERROR';
        }

        $this->args = $args;
        $this->messageCode = $messageCode;

        parent::__construct($message);
    }

    public function getMessageCode(): string
    {
        return $this->messageCode;
    }
}
