<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Cache;

class Item extends Model
{
    protected $fillable = [
        'name',
    ];

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class)
            ->as('details')
            ->withPivot(['id','price','note']);
    }

    protected static function booted()
    {
        self::saved(function () {
            Cache::forget('items_for_livewire');
        });

        self::deleted(function () {
            Cache::forget('items_for_livewire');
        });
    }
}
