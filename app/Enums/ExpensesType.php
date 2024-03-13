<?php

namespace App\Enums;

enum ExpensesType: int
{
    case SALARY = 1;
    case ORDERS = 2;
    case OTHERS = 3;
}
