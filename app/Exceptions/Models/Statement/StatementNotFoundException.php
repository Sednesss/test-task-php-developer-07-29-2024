<?php

namespace App\Exceptions\Models\Statement;

use App\Exceptions\BaseException;

class StatementNotFoundException extends BaseException
{
    public function __construct(string $message = '', array $args = [])
    {
        $message = $message ?: 'Statement not found in the database.';

        parent::__construct($message, $args);
    }
}
