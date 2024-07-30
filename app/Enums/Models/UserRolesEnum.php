<?php

namespace App\Enums\Models;

enum UserRolesEnum: string
{
    case ADMIN = 'admin';
    case CUSTOMER = 'customer';
}
