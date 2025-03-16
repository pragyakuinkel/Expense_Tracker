<?php

namespace App\Enum;

enum Action: String
{
    case Add = 'add';

    case Update = 'update';

    case Delete = 'delete';
}
