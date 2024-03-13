<?php

namespace App\Enums;

enum PaymentStatus: int
{
    case PAID = 1;
    case UNPAID = 2;
}
