<?php

namespace App\Enums\Models;

enum StatementCategoryEnum: string
{
    case INFORMATION_TECHNOLOGY = 'information_technology';
    case POLITICS = 'politics';
    case SOCIAL_SERVICES = 'social_services';
    case MARINE_INDUSTY = 'marine_industry';
    case DAIRY_PRODUCTS = 'dairy_products';
    case MATHEMATICS = 'mathematics';
    case OTHER = 'other';
}
