<?php

namespace App\Enum;

enum Status: string
{
    case CREATED = 'created';

    case AVAILABLE = 'available';

    case LOCK = 'lock';

    case SOLD = 'sold';
}
