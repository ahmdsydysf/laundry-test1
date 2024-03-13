<?php

namespace App\Enums;

enum Roles :int
{
    case SUPER_ADMIN = 1;
    case ADMIN = 2;
    case EMPLOYEE = 3;
}
