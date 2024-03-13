<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrderDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'item_id',
        'service_id',
        'price',
        'quantity',
        'total_price',
        'is_payment_deferred',
        'description',
    ];

    ####################### Relations ############################

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
//
//    public function services(): BelongsToMany
//    {
//        return $this->belongsToMany(Service::class, 'order_details_services')
//            ->as('order_services')
//            ->withPivot(['price']);
//    }
}
