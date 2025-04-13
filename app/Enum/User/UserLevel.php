<?php

namespace App\Enum\User;

enum UserLevel: string
{
    case ADMIN = 'admin';
    case LEADER = 'leader';
    case USER = 'user';
}
