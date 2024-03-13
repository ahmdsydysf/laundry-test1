<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Cache;

class Service extends Model
{
    protected $fillable = [
        'name'
    ];

    public function items(): BelongsToMany
    {
        return $this->belongsToMany(Item::class)
            ->as('details')
            ->withPivot(['price', 'note']);
    }

    protected static function booted()
    {
        self::saved(function () {
            Cache::forget('Services-livewire');
        });

        self::deleted(function () {
            Cache::forget('Services-livewire');
        });
    }
}
