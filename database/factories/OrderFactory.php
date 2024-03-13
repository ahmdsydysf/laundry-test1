<?php

namespace Database\Factories;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Models\Customer;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        $created_by_customer = $this->faker->boolean;
        return [
            'order_code' => $this->faker->word(),
            'total_price' => $this->faker->randomNumber(),
            'final_total_price' => $this->faker->randomNumber(),
            'has_deferred_payment' => $this->faker->boolean(),
            'status' => $this->faker->randomElement(OrderStatus::class),
            'payment_status' => $this->faker->randomElement(PaymentStatus::class),
            'customer_id' => Customer::inRandomOrder()->first()->id,
            'user_id' => $created_by_customer ? null : User::inRandomOrder()->first()->id,
            'created_by_customer' => $created_by_customer,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
