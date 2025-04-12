<?php

namespace App\Enum\User;

enum UserLevel: string
{
    case ADMIN = 'admin';
    case USER = 'user';
}
