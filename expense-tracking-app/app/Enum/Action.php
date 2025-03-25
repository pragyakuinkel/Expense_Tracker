<?php

namespace App\Enum;

enum Action: string
{
    case Add = 'add';

    case Update = 'update';

    case Delete = 'delete';
}
