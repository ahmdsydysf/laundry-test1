<?php

namespace App\Enums;

enum PaymentType: int
{
    case CASH = 1;
    case DEFERRED = 2;
}
