<?php

namespace App\Enums\Models;

enum StatementStateEnum: string
{
    case STARTED = 'started';
    case VIEWED = 'viewed';
    case PROCESSING = 'processing';
    case CLOSED = 'closed';
    case CANCELED = 'canceled';
}
