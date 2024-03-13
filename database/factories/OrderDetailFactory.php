<?php

namespace Database\Factories;

use App\Models\ItemService;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class OrderDetailFactory extends Factory
{
    protected $model = OrderDetail::class;

    public function definition(): array
    {
        $itemService = ItemService::inRandomOrder()->first();
        $is_payment_deferred = $this->faker->boolean;
        $price = $itemService->price ?: rand(5, 25);

        if ($is_payment_deferred) {
            $price = null;
        }
        $quantity = rand(1, 10);
        $total_price = $is_payment_deferred ? null : $price * $quantity;
        return [
            'description' => null,
            'quantity' => $quantity,
            'price' => $price,
            'total_price' => $total_price,
            'is_payment_deferred' => $is_payment_deferred,
            'order_id' => Order::inRandomOrder()->first()->id,
            'service_id' => $itemService->service_id,
            'item_id' => $itemService->item_id,
//            'item_service_id' => $this->faker->randomNumber(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
