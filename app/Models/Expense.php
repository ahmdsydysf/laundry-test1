<?php

namespace App\Models;

use App\Enums\ExpensesType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'user_id',
        'value',
        'description',
    ];

    protected $casts = [
        'type' => ExpensesType::class
    ];

    public function getReadableTypeAttribute(): string
    {
        return match ($this->type) {
            ExpensesType::SALARY => 'مرتبات',
            ExpensesType::ORDERS => 'طلبات',
            ExpensesType::OTHERS => 'اخري'
        };
    }

    public static function typeValues(): array
    {
        return [
            ExpensesType::SALARY->value => 'مرتبات',
            ExpensesType::ORDERS->value => 'طلبات',
            ExpensesType::OTHERS->value => 'اخري',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
